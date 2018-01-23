<?php

namespace frontend\controllers;

use yii\redis\Connection;

class RedisController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRedis()
    {
        //设置一个redis
        $redis=new Connection();
        //$redis->set("name",'1111');
        echo $redis->get("name");
    }
    
    //session 入redis
    public function actionSession()
    {
        //\Yii::$app->session->set('name','1111');
      echo \Yii::$app->session->get('name');
    }
}
