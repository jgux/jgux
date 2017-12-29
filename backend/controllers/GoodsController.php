<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\UploadedFile;
use flyok666\qiniu\Qiniu;
class GoodsController extends \yii\web\Controller
{
    //首页
    public function actionIndex()
    {
        $models=Goods::find()->all();
        return $this->render('index',compact("models"));
    }
    
    //添加
    public function actionAdd()
    {
        $model=new Goods();
        //找到所有的分类
        $cates=Category::find()->asArray()->all();
        //转化为键值对
        $catesArray=ArrayHelper::map($cates,'id','name');
        //转为json格式
        $cates=Json::encode($cates);
        //品牌
        $brs = Brand::find()->asArray()->all();
        //转化为键值对
        $brsArray=ArrayHelper::map($brs,'id','name');
        //商品内容
        $goodsIntro=new GoodsIntro();

        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //var_dump($model);exit;
                //设置录入时间
                $model->inputtime=time();
                if ($model->save()) {
                    $goodsIntro->load($request->post());
                    $goodsIntro->goods_id=$model->id;
                    $goodsIntro->save();
                    \Yii::$app->session->setFlash('info',"数据提交成功");
                    return $this->redirect(["index"]);
                }

            }else{
                //TODO
                \Yii::$app->session->setFlash('danger',"数据提交失败");
                return $this->refresh();
            }
        }

        return $this->render('add', compact('model','cates','brsArray','goodsIntro'));
    }

    //编辑
    //添加
    public function actionEdit($id)
    {
        $model=Goods::findOne($id);
        //找到所有的分类
        $cates=Category::find()->asArray()->all();
        //转化为键值对
        $catesArray=ArrayHelper::map($cates,'id','name');
        //转为json格式
        $cates=Json::encode($cates);
        //品牌
        $brs = Brand::find()->asArray()->all();
        //转化为键值对
        $brsArray=ArrayHelper::map($brs,'id','name');
        //商品内容
        $goodsIntro=GoodsIntro::find()->where(["goods_id"=>$id])->one();

        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //var_dump($model);exit;
                //设置录入时间
                $model->inputtime=time();
                if ($model->save()) {
                    $goodsIntro->load($request->post());
                    $goodsIntro->goods_id=$model->id;
                    $goodsIntro->save();
                    \Yii::$app->session->setFlash('info',"数据提交成功");
                    return $this->redirect(["index"]);
                }

            }else{
                //TODO
                \Yii::$app->session->setFlash('danger',"数据提交失败");
                return $this->refresh();
            }
        }

        return $this->render('add', compact('model','cates','brsArray','goodsIntro'));
    }
    
    //图片处理
    public function actionImgUpload()
    {

        $config = [
            'accessKey'=>'8h4Fp5E2aMRn6dX_k47jw5kkz_iT_DZzhxekm-iB',
            'secretKey'=>'CZl0iHYfj6qoEiN51Cm3FLdFy6xwiIGYvMos2SsA',
            'domain'=>'http://p1jsqm3m0.bkt.clouddn.com',
            'bucket'=>'yii2jd',
            'area'=>Qiniu::AREA_HUANAN
        ];
        $qiniu = new Qiniu($config);//实例化对象
        $key = uniqid();
        //var_dump($_FILES);exit();
        $qiniu->uploadFile($_FILES['file']['tmp_name'],$key);//调用上传方法
        $url = $qiniu->getLink($key);//得到上传后的地址
        $result=[
            'code'=>0,
            'url'=>$url,
            'attachment'=>$url
        ];
        return json_encode($result);
    }

    //查看内容
    public function actionContent($id)
    {
        $model=GoodsIntro::find()->where(['goods_id'=>$id])->one();

        return $this->render('content',compact('model'));
    }


    //富文本处理
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }




}
