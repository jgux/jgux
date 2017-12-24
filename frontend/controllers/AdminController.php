<?php

namespace frontend\controllers;

use frontend\models\Admin;
use yii\web\Request;
use yii\web\UploadedFile;

class AdminController extends \yii\web\Controller
{
    //登录界面
    public function actionIndex()
    {
        $models=Admin::find()->orderBy("id")->all();
        return $this->render("index", ['models' => $models]);
    }
    //注册页面
    public function actionRegister()
    {
        $model=new Admin();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            //密码加密
            $password=\Yii::$app->security->generatePasswordHash($model->password);
            $model->password=$password;
            //开始弄图片 临时存放
            $model->imgFile=UploadedFile::getInstance($model,"imgFile");
            //验证
            if($model->validate()===false){
                //TODO 修改错误
                var_dump($model->getErrors());exit;
            }
            //拼装路径
            $imgPath="images/".uniqid().".".$model->imgFile->extension;
            //保存图片
            if($model->imgFile->saveAs($imgPath,true)){
                $model->img=$imgPath;
                //验证码 只能验证一次
                if($model->save(false)){
                    return $this->redirect(["index"]);
                }
            }
        }

        return $this->render("register",compact("model"));
    }
    //验证码
    public function action()
    {
        return[
            'captcha'=>[
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 5,
            ]
        ];
    }
    
    
    //登录功能
    public function actionLogin()
    {
        $model=new Admin();
        if(\Yii::$app->request->isPost){
            //绑定数据
            $model->load(\Yii::$app->request->post());
            //验证有没有当前用户
            $admin=Admin::find()->where(['name'=>$model->name])->one();
            if($admin){
                //验证密码
                //var_dump($admin->password);exit;
                $result=\Yii::$app->security->validatePassword($model->password,$admin->password);

                if($result){
                    //验证成功 条用user组件实现登录
                    if (\Yii::$app->user->login($admin)){
                        //登录成功提示
                        \Yii::$app->session->setFlash("info","登录成功");
                        return $this->redirect(["index"]);
                    }

                }
            }else{
                $model->addError("name","用户名不存在");
            }
        }

        return $this->render("login",compact("model"));
    }


    public function actionTest(){

        var_dump(\Yii::$app->security->validatePassword('6','$2y$13$7jSC26c1TAmjWA2Fgj8TnuOu3UYdWMrFXGmEvjeArc8f1TKvtJNXe'));
    }


}
