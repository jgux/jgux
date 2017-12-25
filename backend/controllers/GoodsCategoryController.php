<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\web\Request;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=GoodsCategory::find()->all();
        return $this->render('index',compact("models"));
    }

    //添加方法
    public function actionAdd()
    {
        $model=new GoodsCategory();
        $request=new Request();
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()) {
                if ($model->save()) {
                  \Yii::$app->session->setFlash("info","保存数据成功");
                  return $this->redirect(['index']);
                }
            }else{
                //TODO
                var_dump($model->errors);exit;
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    //编辑方法
    public function actionEdit($id)
    {
        $model=GoodsCategory::findOne($id);
        $request=new Request();
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()) {
                if ($model->save()) {
                    \Yii::$app->session->setFlash("info","保存数据成功");
                    return $this->redirect(['index']);
                }
            }else{
                //TODO
                var_dump($model->errors);exit;
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    //删除方法
    public function actionDel($id)
    {
        if (GoodsCategory::findOne($id)->delete()) {
            \Yii::$app->session->setFlash("danger","删除数据成功");
            return $this->redirect(['index']);
        }
    }




}
