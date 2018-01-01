<?php

namespace backend\controllers;

use backend\models\GoodsGallery;
use flyok666\qiniu\Qiniu;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsGalleryController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        $models=GoodsGallery::find()->where(["goods_id"=>$id])->asArray()->all();
      /*  //path组装为一维数组
        $path=array_column($model,'path');
        $model->path=$path;*/
        //var_dump($model);exit;
        return $this->render('index', ['models' => $models]);
    }

    //添加多图
    public function actionAdd($id)
    {
        //var_dump($id);exit;
        $model=new GoodsGallery();
        $request=new Request();
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                $model->path=Json::encode($model->path);
                //var_dump($model);exit;
                $model->save();
                \Yii::$app->session->setFlash('info',"添加多图成功");
                return $this->redirect(['index']);
            }else{
                //TODO
                var_dump($model->errors);exit;
            }
        }

        return $this->render('add',compact('model','id'));
    }

    //处理图片的方法
    public function actionImgUpload()
    {
        //原方法
        /*$file=UploadedFile::getInstanceByName('file');
        //路径
        $path="images/goods/".uniqid().".".$file->extension;
        //var_dump($path);
        $file->saveAs($path,false);
        $result=[
            'code'=>0,
            'url'=>'/'.$path,
            'attachment'=>$path
        ];
        return json_encode($result);*/

        //七牛云
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
        $url = $qiniu->getLink($key);//得到上传后的地址
        $result=[
            'code'=>0,
            'url'=>$url,
            'attachment'=>$url
        ];
        return json_encode($result);



    }

}
