<?php

namespace frontend\controllers;

class GoodsController extends \yii\web\Controller
{
    //商品列表页
    public function actionLists()
    {
        return $this->render('lists');
    }
    
    //商品详情页
    public function actionGoods()
    {
        return$this->render('goods');
    }

}
