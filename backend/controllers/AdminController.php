<?php

namespace backend\controllers;

use backend\models\Admin;
use common\models\LoginForm;
use yii\helpers\ArrayHelper;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    //添加
    public function actionAdd()
    {
        /*//创建管理员
        $admin=new Admin();
        $admin->username='admin';
        $admin->password='123456';
        //加密
        $admin->password=\Yii::$app->security->generatePasswordHash($admin->password);
        //生成密令
        $admin->auth_key=\Yii::$app->security->generateRandomString();
        $admin->save();

        //1.声明RBAC对象
        $auth=\Yii::$app->authManager;
        //创建一个角色
        $role=$auth->createRole('admin');
        //角色入库
        $auth->add($role);
        //2.创建|找到角色 分组
        $role=$auth->getRole('admin');
        //3.添加权限
        //4.给角色分配权限
        //5.把用户分配到角色
        $auth->assign($role,$admin->id);
        \Yii::$app->session->setFlash('success','注册成功');
        return $this->redirect(['index']);*/
        $model=new Admin();
        $request=\Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            //var_dump($model->roles);exit;
            if($model->validate()){
                //加密
                $model->password=\Yii::$app->security->generatePasswordHash($model->password);
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
/*        //实例化LoginForm模型
        $model=new LoginForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            //echo "<pre>";
            //var_dump($model);exit;
            if($model->validate()){
                //1.找用户名
                $admin=Admin::findOne(['username'=>$model->username]);
                //var_dump($admin->password);exit;
                if($admin){
                    //2.判定密码 hash解密
                    if(\Yii::$app->security->validatePassword($model->password,$admin->password)){
                        //调用user组成 成功登录
                        \Yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);
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

        }*/
        $model=new \backend\models\LoginForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $admin=Admin::findOne(['username'=>$model->username]);
                if($admin){
                    //2.判定密码 hash解密
                    if(\Yii::$app->security->validatePassword($model->password,$admin->password)){
                        //调用user组成 成功登录
                        \Yii::$app->user->login($admin);
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

}
