<?php

namespace frontend\controllers;

use backend\models\Category;
use backend\models\Goods;
use frontend\models\Cart;
use yii\web\Cookie;

class GoodsController extends \yii\web\Controller
{
    //商品列表页
    public function actionLists($id)
    {
        //1.找出当前分类
        $cate=Category::findOne($id);
        //2.找出当前分类的所有子类，同一颗树，左值右值
        $cateSons=Category::find()->where(['tree'=>$cate->tree])->andWhere("lft>={$cate->lft}")->andWhere("rgt<={$cate->rgt}")->all();
        //3通过二维数组中的id的值 找到所有的商品
        $cateIds=array_column($cateSons,'id');
        $goods=Goods::find()->where(['in','goods_category_id',$cateIds])->asArray()->all();
        //var_dump($goods);exit;

        return $this->render('lists',compact("goods"));
    }
    
    //商品详情页
    public function actionGoods()
    {
        return$this->render('goods');
    }

    //购物车-设置到cookie里面
    public function actionAddCart($id,$amount)
    {
        //未登录
        if (\Yii::$app->user->isGuest) {
            //2.1 取出cookie
            $cartOld=\Yii::$app->request->cookies->getValue('cart',[]);
            //2.2 判断$cartOld 里有没有当前商品Id
            if (array_key_exists($id,$cartOld)) {
                //存在 修改操作
                $cartOld[$id]=$cartOld[$id]+$amount;
            }else{
                //不存在商品 执行增操作
                $cartOld[$id]=$amount;
            }
            //1.得到cookie对象
            $cookies = \Yii::$app->response->cookies;
            //$cookies->expire=time()+3600;
            //2 发送相应 添加一个新的cookie
            $cookies->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' => $cartOld,
                'expire'=>time()+3600*24*7,
            ]));
            return $this->redirect('cart-lists');

        }else{
            //登录 存数据库
            //1.获取用户id
            $user_id=\Yii::$app->user->identity->id;
            //$cart=Cart::findOne(['user_id'=>$user_id]);
            //var_dump($cart);exit;
            //2.查找存入记录
            $good=Cart::find()->where(['user_id'=>$user_id])->andWhere(['goods_id'=>$id])->one();
            //var_dump($good);exit;
            $cart=new Cart();
            if($good){
                //$good['id']=$id;
                $good->amount=$amount+$good->amount;
                //$cart->user_id=$user_id;
                $good->save();
                return $this->redirect(["goods/cart-lists?user_id={$user_id}"]);
            }
            $cart->goods_id=$id;
            $cart->amount=$amount;
            $cart->user_id=$user_id;
            $cart->save();

            return $this->redirect(["goods/cart-lists?user_id={$user_id}"]);
        }




    }

    //购物车-得到cookie
    public function actionCartLists()
    {
        //var_dump($id,$amount);
        //1未登录
        if (\Yii::$app->user->isGuest) {
            //存cookie
            //1.1判断以前存过cooike没有
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
            //1.2 取出所有的Id
            $goodIds=array_keys($cart);
            //1.3通过id获取所有商品
            $goods=Goods::find()->where(["in","id",$goodIds])->asArray()->all();
            foreach ($goods as $k=>$good){
                $goods[$k]['num']=$cart[$good['id']];
            }
            return $this->render('cart-lists',compact('goods'));
        }else{
            //登录存 数据库
            $user_id=$_GET['user_id'];
            //var_dump($user_id);exit;
            $carts=Cart::find()->where(['user_id'=>$user_id])->asArray()->all();
            //var_dump($carts);
            //1.2 取出所有的Id
            $goodIds=array_column($carts,"goods_id");
            $goodNum=array_column($carts,"amount");
            //var_dump($goodNum);exit();
            //1.3获取所有的商品
            $goods=Goods::find()->where(['in',"id",$goodIds])->asArray()->all();
            foreach ($goods as $k=>$good){
                $goods[$k]['num']=$goodNum[$k];
            }
            //var_dump($goods);exit;
            return $this->render('cart-lists',compact('goods'));


        }

        //echo 111;

    }

    //购物车-编辑cookie列表的值
    public function actionUpdateCart($id,$amount)
    {
        //判定游客
        if (\Yii::$app->user->isGuest) {
            //1.取出购物车数据库
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
            $cart[$id]=$amount;
            //2.得到cookie对象
            $setCookie=\Yii::$app->response->cookies;
            //3生成一个新的cookie对象
            $cookie=new Cookie([
               'name'=>'cart',
               'value' => $cart,
                'expire' => time() +3600*24*7,
            ]);
            $setCookie->add($cookie);
            return 1;
        }else{
            //登录
            $user_id=\Yii::$app->user->identity->id;
            $good=Cart::find()->where(['user_id'=>$user_id])->andWhere(['goods_id'=>$id])->one();
            $good->amount=$amount;
            $good->save();
            return 1;
        }

    }

    //购物车 删除
    public function actionDelCart($id)
    {
        //游客
        if(\Yii::$app->user->isGuest){

            //1.取出购物数据
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
            //1.1 删除数组中的id unset|array_splice() 前一个索引不变|后一个变
            unset($cart[$id]);

            //2.设置新的cookie对象
            $cookie=\Yii::$app->response->cookies;
            // 在要发送的响应中添加一个新的 cookie
            $cookie->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' =>$cart,
            ]));
            //删除对象
            //unset($cookie[$id]);
            //返回1 确认删除数据成功
            return $this->redirect(['cart-lists']);
        }else{
            //登录
            $user_id=\Yii::$app->user->identity->id;
            $cart=Cart::find()->where(['user_id'=>$user_id])->andWhere(['goods_id'=>$id])->one();
            if ($cart->delete()) {
                return $this->redirect(['goods/cart-lists']);
            }

        }

    }

    public function actionCartAddress()
    {
        $user_id=\Yii::$app->user->identity->id;
        $carts=Cart::find()->where(['user_id'=>$user_id])->asArray()->all();
        //var_dump($carts);
        //1.2 取出所有的Id
        $goodIds=array_column($carts,"goods_id");
        $goodNum=array_column($carts,"amount");
        //var_dump($goodNum);exit();
        //1.3获取所有的商品
        $goods=Goods::find()->where(['in',"id",$goodIds])->asArray()->all();
        foreach ($goods as $k=>$good){
            $goods[$k]['num']=$goodNum[$k];
        }
        //var_dump($goods);exit;
        return $this->render('cart-address',compact('goods'));

    }


    //测试cookie
    public function actionTest()
    {
        var_dump(\Yii::$app->request->cookies->getValue('cart'));
    }

}
