<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class AuthItemChildController extends \yii\web\Controller
{
    //展示权限
    public function actionIndex()
    {
        //实例化Rbac
        $autn=\Yii::$app->authManager;
        //查出所有角色
        $roles=$autn->getRoles();
        return $this->render('index',compact("roles"));
    }

    //添加权限并追加到角色
    public function actionAdd()
    {
        $model=new AuthItem();
        //实例化RBAC
        $auth=\Yii::$app->authManager;
        $request=\Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                //创建角色
                $role=$auth->createRole($model->name);
                //添加描述
                $role->description=$model->description;
                //添加权限 并入库
                if($auth->add($role)){
                    //给用户追加权限
                    if($model->permissions){
                        foreach ($model->permissions as $permission){
                            //添加到角色
                            $auth->addChild($role,$auth->getPermission($permission));
                        }
                    }

                }
                \Yii::$app->session->setFlash("success","创建".$model->description."成功");
                return $this->redirect(['index']);
            }
        }


        //得到所有权限
        $permissions=$auth->getPermissions();
        //转化为键值对
        $permissions=ArrayHelper::map($permissions,'name','description');
        return $this->render('add',compact('model','permissions'));
    }

    //编辑
    public function actionEdit($name)
    {
        //$model=new AuthItem();
        $model=AuthItem::findOne($name);
        //var_dump($model);exit;
        //实例化RBAC
        $auth=\Yii::$app->authManager;
        //得到角色权限
        $rolePermission=$auth->getPermissionsByRole($name);
        //var_dump(array_keys($rolePermission));exit;//回显权限
        $model->permissions=array_keys($rolePermission);
        $request=\Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                //找出当前对象的权限
                $role=$auth->getRole($model->name);
                //var_dump($role);exit;
                if($role){
                    //添加描述
                    $role->description=$model->description;
                    //先删除 在添加
                    if($auth->update($model->name,$role)){
                        $auth->removeChildren($role);
                        if($model->permissions){
                            //循环加入
                            foreach ($model->permissions as $permission){
                                $auth->addChild($role,$auth->getPermission($permission));
                            }
                        }
                    }

                    \Yii::$app->session->setFlash("success","修改".$model->description."成功");
                    return $this->redirect(['index']);

                }


                \Yii::$app->session->setFlash("danger","不能修改角色名称".$model->name);
                return $this->redirect(['index']);
            }
        }


        //得到所有权限
        $permissions=$auth->getPermissions();
        //转化为键值对
        $permissions=ArrayHelper::map($permissions,'name','description');
        return $this->render('add',compact('model','permissions'));
    }



}
