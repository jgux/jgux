<?php

namespace backend\controllers;

use backend\models\GoodsIntro;

class GoodsIntroController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=GoodsIntro::find()->all();
        return $this->render('index',compact('models'));
    }

}
