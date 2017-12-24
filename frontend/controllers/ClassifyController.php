<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/18
 * Time: 20:30
 */

namespace frontend\controllers;


use frontend\models\GoodsClassify;
use yii\web\Controller;
use yii\web\Request;

class ClassifyController extends Controller
{
    public function actionIndex()
    {
        $models=GoodsClassify::find()->all();
        return $this->render("index",compact("models"));
    }

    public function actionAdd()
    {
        $models=new GoodsClassify();
        $request=new Request();
        if($request->isPost){
            $models->load($request->post());
            //验证
            if($models->validate()){
                if($models->save()){
                    //跳转
                    return $this->redirect(["index"]);
                }
            }else{
                //TODO 验证错误
                var_dump($models->getErrors());exit;//验证错误一定要停止
            }
        }

        return $this->render("add",compact("models"));
    }

    public function actionEdit($id)
    {
        $models=GoodsClassify::findOne($id);
        var_dump($models->goods);exit;
        $request=new Request();
        if($request->isPost){
            $models->load($request->post());
            //验证
            if($models->validate()){
                if($models->save()){
                    //跳转
                    return $this->redirect(["index"]);
                }
            }else{
                //TODO 验证错误
                var_dump($models->getErrors());exit;//验证错误一定要停止
            }
        }

        return $this->render("add",compact("models"));
    }

    public function actionDel($id)
    {
        if (GoodsClassify::findOne($id)->delete()) {
            return $this->redirect(["index"]);
        }
    }
}