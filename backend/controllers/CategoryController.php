<?php

namespace backend\controllers;

use backend\models\Category;
use yii\helpers\Json;
use yii\web\Request;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Category::find()->all();
        return $this->render('index',compact('models'));
    }

    //添加
    public function actionAdd()
    {
        $model=new Category();
        //找到所有的分类
        $cates=Category::find()->asArray()->all();
        $cates[]=['id'=>0,'name'=>'一级分类','parent_id'=>0];
        //转为json格式
        $cates=Json::encode($cates);
        //var_dump($cates);exit;
        $request=new Request();
        if ($request->isPost) {
            $model->load($request->post());
            //验证
            if ($model->validate()){
                //一级分类
                if ($model->parent_id==0){
                    $model->makeRoot();
                    \Yii::$app->session->setFlash('info','添加一级分类成功');
                }else{
                    //子节点
                    //1 找到父对象
                    $parent=Category::findOne($model->parent_id);
                    //var_dump($parent);exit;
                    //2 创建子节点
                    //3 追加到父节点
                    $model->prependTo($parent);
                    \Yii::$app->session->setFlash('info',"把".$model->name."添加到".$parent->name."下成功");
                }
                //刷新页面
                return $this->refresh();
            }else{
                //TODO
                var_dump($model->errors);
            }
        }
        return $this->render('add', compact('model','cates'));
    }

    //编辑
    public function actionEdit($id)
    {
        $model=Category::findOne($id);
        //找到所有的分类
        $cates=Category::find()->asArray()->all();
        $cates[]=['id'=>0,'name'=>'一级分类','parent_id'=>0];
        //转为json格式
        $cates=Json::encode($cates);
        //var_dump($cates);exit;
        $request=new Request();
        if ($request->isPost) {
            $model->load($request->post());
            //验证
            if ($model->validate()){
                //一级分类
                if ($model->parent_id==0){
                    $model->makeRoot();
                    \Yii::$app->session->setFlash('info','修改一级分类成功');
                }else{
                    //子节点
                    //1 找到父对象
                    $parent=Category::findOne($model->parent_id);
                    //var_dump($parent);exit;
                    //2 创建子节点
                    //3 追加到父节点
                    $model->prependTo($parent);
                    \Yii::$app->session->setFlash('info',"把".$model->name."修改到".$parent->name."下成功");
                }
                //刷新页面
                return $this->redirect(['index']);
            }else{
                //TODO
                var_dump($model->errors);
            }
        }
        return $this->render('add', compact('model','cates'));
    }

    //删除
    public function actionDel($id)
    {
        if (Category::findOne($id)->deleteWithChildren()) {
            \Yii::$app->session->setFlash('danger','删除分类成功');
            return $this->redirect(['index']);
        }
    }

}
