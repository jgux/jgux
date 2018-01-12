<?php

namespace frontend\controllers;

use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{
    //public $enableCsrfValidation = false; 关闭crsf
    //验证码
    public function actions()
    {
        return [
            'captcha'=>[
                'class'=>'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4

            ]

        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegist()
    {
        $request=\Yii::$app->request;
        if ($request->isPost){
            //实例化user
            $user =new User();
            //绑定数据
            $user->setScenario('reg');
            $user->load($request->post());
            //return 1;
            if($user->validate()){
                //保存数据
                $user->password_hash=\Yii::$app->security->generatePasswordHash($user->password);
                //var_dump($user->captcha);exit;
               //获取手机号对应的验证码
                $code=\Yii::$app->session->get('tel'.$user->mobile);
                if ($code == $user->captcha){
                    if($user->save(false)){//验证码只能验证一次
                        return Json::encode(
                            [
                                'status'=>1,
                                'msg'=>"注册成功",
                                'data'=>null
                            ]
                        );

                    }
                }else{
                    $user->addError('captcha',"验证码错误");
                }  //问下老问 怎么处理 短信验证的问题

            }//
            //var_dump($user->errors);exit;
            return Json::encode(
                [
                    'status'=>0,
                    'msg'=>"注册失败",
                    'data'=>$user->errors
                ]
            );
        }


        return $this->render('regist');
    }


    //手机验证
    public function actionSms($mobile)
    {
        //1生成验证码 规则6位
        $code=rand(1000,9999);

       //2发送验证码给手机
        $config = [
            'access_key' => 'LTAIoa126B4V7URl',//应用ID
            'access_secret' => 'rXejLuqHUZzfirQCE8zjfgEO5rFxbe',//密钥
            'sign_name' => '蒋国兴',//签名
        ];
        $aliSms = new AliSms();
        $response = $aliSms->sendSms($mobile, 'SMS_120410862', ['code'=>$code], $config);
        var_dump($response);
        //3存短信 发送手机成功才存起来
        \Yii::$app->session->set('tel'.$mobile,$code);
        return $code;
        
    }
    
    //处理手机验证
    public function actionCheck($tel)
    {
        //根据手机号取对应的验证码
        $code=\Yii::$app->session->get($tel);
        //return $code;

    }

    //登录
    public function actionLogin()
    {
        $request=\Yii::$app->request;
        if ($request->isPost){
            $model=new User();
            $model->scenario="login";
            $model->load($request->post());
            if($model->validate()){
                //1.找到对象
                $user=User::findOne(['username'=>$model->username]);
                //2.用户存在|验证密码
                if($user && \Yii::$app->security->validatePassword($model->password,$user->password_hash)){
                //3.成功登录
                    \Yii::$app->user->login($user,$model->rememberMe?3600*24*7:0);
                    return $this->redirect(['index/index']);
                }
                echo "密码错误";exit;
            }
            //TODO
            var_dump($model->errors);exit;

        }

        return $this->render("login");
    }
    
    //注销
    public function actionLogout()
    {
        if (\Yii::$app->user->logout()) {
            return $this->redirect(['user/login']);
        }
    }

}
