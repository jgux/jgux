<?php

namespace frontend\controllers;

use frontend\components\ShopCart;
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

        /*
         * 1. 每个手机号每隔60秒才再再次发送
         * 1.1 当前时间time()-send_time<60,则提示不能发送，否则能发送，更新send_time
         * 2. 每个手机号每天只能3条
         * 2.1 判断当天有没有发送过，执行添加操作，如果当天已经有发送，判断times>=3,则不能发送;否则给times+1
         *
         * 入库
         *   tel  code    times    date      send_time
         *   188  1111      1   20180115     22222222
         *
         * 3.由于网络不好，导致短信前后不一致的问题
         * 3.1 当前时间time()-send_time<5*60  1111  1111   1111
         *
         *1=》1111  2=1111  3=1111          序号
         *
         * */
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
    public function actionLogin($back='index/index')
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
                //同步cookie里的数据到数据库
                $shopCart=new ShopCart();
                $shopCart->synDb();//同步cookie到数据库
                $shopCart->flush()->save();



                    return $this->redirect([$back]);
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
