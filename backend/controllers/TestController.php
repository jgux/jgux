<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2018/1/3
 * Time: 22:16
 */

namespace backend\controllers;


use yii\web\Controller;

class TestController extends Controller
{
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>\backend\filters\RbacFilter::className(),
            ]
        ];
    }
}