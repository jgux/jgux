<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Article::find()->where(["reclaim"=>1])->all();
        return $this->render('index',compact("models"));
    }

    //添加方法
    public function actionAdd()
    {
        $model=new Article();
        $detail=new ArticleDetail();
        //得到所有的分类
        $class=ArticleCategory::find()->asArray()->all();
        //转化为键值对
        $classArray=ArrayHelper::map($class,'id','name');
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $detail->load($request->post());
            if($model->validate()){
                //给与录入时间
                $model->inputtime=time();
                if ($model->save()) {
                    //获取保存的id $model->id
                    $detail->article_id=$model->id;
                    if ($detail->save()) {
                        echo \Yii::$app->session->setFlash("success","保存数据成功");
                        return $this->redirect(["index"]);
                    }
                }
            }else{
                //TODO
                var_dump($model->getErrors());
            }
        }

        return $this->render("add", compact("model","detail",'classArray'));
    }

    //编辑方法
    public function actionEdit($id)
    {
        $model=Article::findOne($id);
        $detail=ArticleDetail::findOne($id);
        //得到所有的分类
        $class=ArticleCategory::find()->asArray()->all();
        //转化为键值对
        $classArray=ArrayHelper::map($class,'id','name');
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $detail->load($request->post());
            if($model->validate()){
                //给与录入时间
                $model->inputtime=time();
                if ($model->save()) {
                    //获取保存的id $model->id
                    $detail->article_id=$model->id;
                    if ($detail->save()) {
                        echo \Yii::$app->session->setFlash("success","保存数据成功");
                        return $this->redirect(["index"]);
                    }
                }
            }else{
                //TODO
                var_dump($model->getErrors());
            }
        }

        return $this->render("add", compact("model","detail",'classArray'));
    }

    //删除方法
    public function actionDel($id)
    {
        if (Article::findOne($id)->delete()) {
            echo \Yii::$app->session->setFlash("danger","删除成功");
            return $this->redirect(["index"]);
        }
    }

    public function actionCallback($id)
    {
        $model=Article::findOne($id);
        $model->reclaim=2;
        if ($model->save()) {
            echo \Yii::$app->session->setFlash("danger","回收成功");
            return $this->redirect(["index"]);
        }
    }

    //富文本框
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
        ],
    ];

}

}
