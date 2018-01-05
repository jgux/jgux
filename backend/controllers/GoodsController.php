<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\UploadedFile;
use flyok666\qiniu\Qiniu;
class GoodsController extends \yii\web\Controller
{
    //权限过滤器
    /*public function behaviors()
    {
       return [
         'rbac'=>[
             'class'=>\backend\filters\RbacFilter::className(),
         ]
       ];
    }*/

    //首页
    public function actionIndex()
    {
        //分页
        $query=Goods::find();
        //添加搜索添加
        $request=\Yii::$app->request;
        $minPrice=$request->get('minPrice');
        $maxPrice=$request->get('maxPrice');
        $keyWord=$request->get('keyWord');
        $status=$request->get('status');
        if ($minPrice){
            $query->andWhere("shop_price>={$minPrice}");
        }
        if($maxPrice){
            $query->andWhere("shop_price<={$maxPrice}");
        }
        if($keyWord){
            $query->andWhere("name like '%{$keyWord}%' or sn like '%{$keyWord}%'");
        }
        //状态
        if($status==='0' or $status==='1'){
            $query->andWhere(["status"=>$status]);
        }
        $pages=new Pagination([
           'totalCount' => $query->count(),
           'pageSize' => 1
        ]);
        $models=$query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', ['models' => $models,'pages'=>$pages]);
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
               //判定货号sn是否存在
                if(empty($model->sn)){
                    //自动生成货号
                    $timeStart=strtotime(date('Ymd'));
                    //获取今天创建的所有商品数量
                    $count=Goods::find()->where("inputtime>={$timeStart}")->count();
                    $count=$count+1;
                    $count=substr('000'.$count,-4);
                    $model->sn=date("Ymd").$count;
                }
                //设置录入时间
                $model->inputtime=time();
                if ($model->save()) {
                    //内容保存
                    $goodsIntro->load($request->post());
                    $goodsIntro->goods_id=$model->id;
                    $goodsIntro->save();
                    //保存多图
                    foreach ($model->imgFile as $img){
                        //new 一个多图对象 在这里 一起地方会被重复赋值
                        $goodsGallery=new GoodsGallery();
                        //赋值
                        $goodsGallery->goods_id=$model->id;
                        $goodsGallery->path=$img;
                        //保存图片
                        $goodsGallery->save();
                    }
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
        $goodsIntro=GoodsIntro::findOne(['goods_id'=>$id]);
        //查询当前商品对应的所有图片
        $goodsImgs=GoodsGallery::find()->where(['goods_id'=>$id])->asArray()->all();
        //返回一维数组回去
        $model->imgFile=array_column($goodsImgs,'path');
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                //var_dump($model);exit;
                //判定货号sn是否存在
                if(empty($model->sn)){
                    //自动生成货号
                    $timeStart=strtotime(date('Ymd'));
                    //获取今天创建的所有商品数量
                    $count=Goods::find()->where("inputtime>={$timeStart}")->count();
                    $count=$count+1;
                    $count=substr('000'.$count,-4);
                    $model->sn=date("Ymd").$count;
                }
                //设置录入时间
                $model->inputtime=time();
                if ($model->save()) {
                    //内容保存
                    $goodsIntro->load($request->post());
                    $goodsIntro->goods_id=$model->id;
                    $goodsIntro->save();
                    //清除以前的图片
                   GoodsGallery::deleteAll(['goods_id'=>$id]);
                    //保存多图
                    foreach ($model->imgFile as $img){
                        //new 一个多图对象 在这里 一起地方会被重复赋值
                        $goodsGallery=new GoodsGallery();

                        //赋值
                        $goodsGallery->goods_id=$model->id;
                        $goodsGallery->path=$img;
                        //保存图片
                        $goodsGallery->save();
                    }
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
