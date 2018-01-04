<?php

namespace backend\controllers;

use backend\models\Admin;
use common\models\LoginForm;
use yii\helpers\ArrayHelper;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Admin::find()->all();
        return $this->render('index',compact("models"));
    }

    //添加
    public function actionAdd()
    {
        $model=new Admin();
        $model->scenario ='add';
        $request=\Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            //var_dump($model);exit;
            if($model->validate()){
                //加密
                $model->password=\Yii::$app->security->generatePasswordHash($model->password);
                //添加令牌
                $model->auth_key=\Yii::$app->security->generateRandomString(5);
                $model->last_login_ip=ip2long(\Yii::$app->request->userIP);
                $model->save();

                //追加到组里面
                //1.声明RBAC对象
                $auth=\Yii::$app->authManager;
                //2.创建|找到角色 分组
                //得到所有的角色权限
                //$roles=$auth->getRoles();
                //循环获得权限
//                foreach ($roles as $role){
//                    $arr[]=$role->name;
//                }
//                $name=$arr[$model->roles];
               // $roles=array_column($roles,'name');
                $role=$auth->getRole($model->roles);
                $auth->assign($role,$model->id);
                \Yii::$app->session->setFlash('success','注册成功');
                return $this->redirect(['index']);
            }
        };
        return $this->render("add", compact('model'));
    }//end

    //编辑
    public function actionEdit($id)
    {
        $model=Admin::findOne($id);
        $request=\Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            //var_dump($model->password);exit;
            if($model->validate()){
                //加密
                //判定密码是否有值
                if($model->password){
                    $model->password=\Yii::$app->security->generatePasswordHash($model->password);
                }else{
                    $model->password=Admin::findOne($id)->password;
                }

                //添加令牌
                $model->auth_key=\Yii::$app->security->generateRandomString(5);
                $model->last_login_ip=ip2long(\Yii::$app->request->userIP);
                $model->save();
                //追加到组里面
                //1.声明RBAC对象
                $auth=\Yii::$app->authManager;
                //2.创建|找到角色 分组
                //得到所有的角色权限
                $roles=$auth->getRoles();
                //循环获得权限
                foreach ($roles as $role){
                    $arr[]=$role->name;
                }
                $name=$arr[$model->roles];
                $role=$auth->getRole($name);
                $auth->revoke($role,$model->id);
                $auth->assign($role,$model->id);
                \Yii::$app->session->setFlash('success','注册成功');
                return $this->redirect(['index']);
            }
        };
        return $this->render("add", compact('model'));
    }//end

    //登录
    public function actionLogin()
    {
        $model=new \backend\models\LoginForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //var_dump($model->rememberMe);exit;
                //判断是否时候用户
                $admin=Admin::findOne(['username'=>$model->username]);
                if($admin){
                    //2.判定密码 hash解密
                    if(\Yii::$app->security->validatePassword($model->password,$admin->password)){
                        //3.调用user组成 成功登录
                        \Yii::$app->user->login($admin,$model->rememberMe?3600*24*30:0);
                        //4.修改登录的ip和时间
                        $admin->created_at=time();
                        $admin->last_login_ip=ip2long(\Yii::$app->request->userIP);
                        $admin->save();
//                        echo 111;exit;
                        return $this->redirect(["goods/index"]);
                    }else{
                        $model->addError('password',"密码错误");
                    }
                }else{//用户不存在
                    \Yii::$app->session->setFlash('danger','用户名不存在');
                    return $this->refresh();
                }
            }
        }


        //展示视图
        return $this->render('login',['model'=>$model]);
    }

    //退出
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    //删除
    public function actionDel($id)
    {
        if (Admin::findOne($id)->delete()) {
            \Yii::$app->session->setFlash("danger","删除成功");
            return $this->redirect(["index"]);
        }
    }

}
