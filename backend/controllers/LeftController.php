<?php

namespace backend\controllers;

class LeftController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //获取所有的的路由

        return $this->render('index');
    }

}
