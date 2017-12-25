<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use yii\web\Request;

class ArticleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=ArticleCategory::find()->all();
        return $this->render('index',compact('models'));
    }
    //添加
    public function actionAdd()
    {
        $model=new ArticleCategory();
        $request=new Request();
        if ($request->isPost){
            $model->load($request->post());
            if($model->validate()) {
                if ($model->save()) {
                    echo \Yii::$app->session->setFlash("success","保存数据成功");
                    return $this->redirect(["index"]);
                }
            }else{
                //TODO
                return var_dump($model->errors);exit;
            }
        }
        return $this->render("add", ['model' => $model]);

    }
    //编辑
    public function actionEdit($id)
    {
        $model=ArticleCategory::findOne($id);
        $request=new Request();
        if ($request->isPost){
            $model->load($request->post());
            if($model->validate()) {
                if ($model->save()) {
                    echo \Yii::$app->session->setFlash("success","保存数据成功");
                    return $this->redirect(["index"]);
                }
            }else{
                //TODO
                return var_dump($model->errors);exit;
            }
        }
        return $this->render("add", ['model' => $model]);

    }

    //删除
    public function actionDel($id)
    {
        if (ArticleCategory::findOne($id)->delete()) {
            echo \Yii::$app->session->setFlash("danger","删除成功");
            return $this->redirect(["index"]);
        }
    }

}
