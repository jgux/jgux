<?php

namespace backend\controllers;

use backend\models\Brand;
use flyok666\qiniu\Qiniu;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $brands=Brand::find()->where(['reclaim'=>1])->all();
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
    public function actionImgUpload()
    {
        /**
         * 1-和原来一样 先得到图片对象
            2-拼装路径
            3-移动图片
         */
        $config = [
            'accessKey' => '8h4Fp5E2aMRn6dX_k47jw5kkz_iT_DZzhxekm-iB',//AK
            'secretKey' => 'CZl0iHYfj6qoEiN51Cm3FLdFy6xwiIGYvMos2SsA',//SK
            'domain' => 'http://p1jsqm3m0.bkt.clouddn.com',//临时域名
            'bucket' => 'yii2jd',//空间名称
            'area' => Qiniu::AREA_HUANAN//区域
        ];
        $qiniu = new Qiniu($config);//实例化对象
        $key=uniqid();
        $qiniu->uploadFile($_FILES['file']["tmp_name"], $key);//调用上传方法上传文件
        /*$file=UploadedFile::getInstanceByName("file");
        if($file){
            $path="images/brand/".uniqid().".".$file->extension;
            //移动图片
            if($file->saveAs($path,false)){*/
             $qiniu = new Qiniu($config);//实例化对象
        $key=uniqid();
        $qiniu->uploadFile($_FILES['file']["tmp_name"], $key);//调用上传方法上传文件
        $url = $qiniu->getLink($key);//得到上传后的地址
                $result=[
                    'code'=>0,
                    'url'=>$url,
                    'attachment'=>$url
                ];
                return json_encode($result);

//            var_dump($path);exit();


    }

    //隐藏
    public function actionCallback($id)
    {
        $model=Brand::findOne($id);
        $model->reclaim=2;
        if ($model->save()) {
            return $this->redirect(["index"]);
        }
    }
    //显示回收站
    public function actionShow()
    {
        $brands=Brand::find()->where(["reclaim"=>2])->all();
        return $this->render("show", ['brands' => $brands]);
    }
    //回显
    public function actionDisplay($id)
    {
        $brand=Brand::findOne($id);
        $brand->reclaim=1;
        if ($brand->save()) {
            return $this->redirect(["index"]);
        }
    }


}
