<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2018/1/23
 * Time: 21:24
 */

namespace frontend\controllers;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;

use yii\web\Controller;

class TestController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(
            [['class' => Cors::className(),],], parent::behaviors());
    }

    public function actionTest()
    {
        echo 222222;
    }
}