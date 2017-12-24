<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $brands=Brand::find()->where(["reclaim"=>1])->all();
        return $this->render('index',["brands"=>$brands]);
    }

    //添加
    public function actionAdd()
    {
        $model=new Brand();
        //判定 接收
        $request=new Request();
        if($request->isPost) {
            $model->load($request->post());
            //验证
            if($model->validate()){
                $model->save();
                return $this->redirect(["index"]);
            }
        }
        return $this->render("add",compact("model"));
    }

    public function actionEdit($id)
    {
        $model=Brand::findOne($id);
        //判定 接收
        $request=new Request();
        if($request->isPost) {
            $model->load($request->post());
            //验证
            if($model->validate()){
                $model->save();
                return $this->redirect(["index"]);
            }
        }
        return $this->render("add",compact("model"));
    }

    //删除方法
    public function actionDel($id)
    {
        $model = Brand::findOne($id);
        unlink($model->img);
        if ($model->delete()) {
            \Yii::$app->session->setFlash("danger","删除成功");
            return $this->redirect(["index"]);
        }
    }
    
    
    //webUploader
    public function actionUpload()
    {
        /**
         * 1-和原来一样 先得到图片对象
            2-拼装路径
            3-移动图片
         */
        $file=UploadedFile::getInstanceByName("file");
        if($file){
            $path="images/brand/".uniqid().".".$file->extension;
            //移动图片
            if($file->saveAs($path,false)){
                $result=[
                  'code'=>0,
                   'url'=>'/'.$path,
                   'attachment'=>$path
                ];
                return json_encode($result);
            }
//            var_dump($path);exit();

        }
    }


    public function actionCallback($id)
    {
        $model=Brand::findOne($id);
        $model->reclaim=2;
        if ($model->save()) {
            return $this->redirect(["index"]);
        }
    }



}
