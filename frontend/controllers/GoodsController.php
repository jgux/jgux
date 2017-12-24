<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/14
 * Time: 19:31
 */

namespace frontend\controllers;


use frontend\models\Goods;
use yii\web\Controller;
use yii\web\Request;

class GoodsController extends Controller
{
    public $enableCsrfValidation=false;
    //展示视图列表
    public function actionIndex()
    {
        $goods =Goods::find()->all();
        return $this->render("index",["goods"=>$goods]);
    }
    //添加数据
    public function actionAdd()
    {
        //new 数据模型对象
        $goods=new Goods();
        //创建request对象
        $request=new Request();
        //判定post
        if($request->getIsPost()){
            //判定数据
            $goods->load($request->post());
            //在做验证
            if($goods->validate()){
                //var_dump($goods);exit;
                //保存数据 并跳转到首页
                if($goods->save()){
                    return $this->redirect(["index"]);
                }

            }else{
                //TODO 验证不通过，打印错误提示 很重要
                var_dump($goods->getErrors());exit;
            }
        }
        //插入视图
        return $this->render("add",["goods"=>$goods]);
    }
    
    //删除数据
    public function actionDel($id)
    {
        //找到这个对象
        $goods=Goods::findOne($id);
       //var_dump($goods);exit;
        $goods->delete();
        return $this->redirect(["index"]);

    }
    //编辑数据
    public function actionEdit($id)
    {
        //new 数据模型对象
        $goods=Goods::findOne($id);
        //创建request对象
        //var_dump($goods->classify->goods_name);exit;
        $request=new Request();
        //判定post
        if($request->getIsPost()){
            //判定数据
            $goods->load($request->post());
            //在做验证
            if($goods->validate()){
                //var_dump($goods);exit;
                //保存数据 并跳转到首页
                if($goods->save()){
                    return $this->redirect(["index"]);
                }

            }else{
                //TODO 验证不通过，打印错误提示 很重要
                var_dump($goods->getErrors());exit;
            }
        }
        //插入视图
        return $this->render("add",["goods"=>$goods]);
    }


}