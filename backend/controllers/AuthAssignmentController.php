<?php

namespace backend\controllers;

use backend\models\AuthItem;

class AuthAssignmentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化RBAC
        $auth=\Yii::$app->authManager;
        //获得所有的权限
        $permissions=$auth->getPermissions();
        return $this->render('index',compact('permissions'));
    }

    //添加权限
    public function actionAdd()
    {
        $model=new AuthItem();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                //实例化RBAC组件
                $auth=\Yii::$app->authManager;
                //创建权限
                $permission=$auth->createPermission($model->name);
                //添加描述
                $permission->description=$model->description;
                //添加权限 入库
                $auth->add($permission);
                \Yii::$app->session->setFlash("success","创建".$model->description."成功");
                return $this->refresh();
            }
        }

        return $this->render("add",compact('model'));
    }

    //编辑
    public function actionEdit($name)
    {
        $model=AuthItem::findOne($name);
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                //实例化RBAC组件
                $auth=\Yii::$app->authManager;
                //创建权限
               // $permission=$auth->createPermission($model->name);
                //找到权限对象
                $permission=$auth->getPermission($model->name);
                if($permission){
                    //添加描述
                    $permission->description=$model->description;
                    //添加权限 入库
                    //$auth->add($permission);
                    //修改权限
                    $auth->update($model->name,$permission);
                    \Yii::$app->session->setFlash("success","修改".$model->description."成功");
                    return $this->redirect(["index"]);
                }else{
                    \Yii::$app->session->setFlash("danger","不能修改权限名称".$model->name);
                    return $this->refresh();
                }
            }
        }

        return $this->render("add",compact('model'));
    }
    
    
    //删除
    public function actionDel($name)
    {
        $auth=\Yii::$app->authManager;
        //找到删除对象
        $permission=$auth->getPermission($name);
        if($auth->remove($permission)){
            \Yii::$app->session->setFlash("success","删除".$name."成功");
            return $this->redirect(["index"]);
        }
    }

}
