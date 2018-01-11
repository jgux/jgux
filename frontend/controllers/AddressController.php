<?php

namespace frontend\controllers;

use frontend\models\Address;

class AddressController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    //添加
    public function actionIndex()
    {
        $model=Address::find()->all();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model=$request->post();
            $address=new Address();
           //var_dump($model->username);exit;
            $address->username=$model['username'];
            $address->province=$model['province3'];
            $address->city=$model['city3'];
            $address->area=$model['area3'];
            $address->detailed=$model['detailed'];
            $address->phone=$model['phone'];
            $address->user_id=\Yii::$app->user->identity->id;
            if($address->save()){
                return $this->refresh();
            }
        }
        return $this->render('index',compact("model"));
    }



}
