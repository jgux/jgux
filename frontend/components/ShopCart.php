<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2018/1/12
 * Time: 9:54
 */

namespace frontend\components;


use frontend\models\Cart;
use yii\base\Component;

class ShopCart extends Component
{
    //声明一个静态的属性
    private $_cart=[];
    public function __construct(array $config = [])
    {

        //2.1 取出cookie
        $this->_cart=\Yii::$app->request->cookies->getValue('cart',[]);
        parent::__construct($config);
    }

    //添加方法
    public function add($id,$amount)
    {
        //2.2 判断$cartOld 里有没有当前商品Id
        if (array_key_exists($id,$this->_cart)) {
            //存在 修改操作
            $this->_cart[$id]=$this->_cart[$id]+$amount;
        }else{
            //不存在商品 执行增操作
            $this->_cart[$id]=$amount;
        }
        //返回当前对象
        return $this;
    }

    //update
    public function update($id,$amount)
    {
        if(isset($this->_cart[$id])){
            $this->_cart[$id]=$amount;
        }
        return$this;
    }

    //select
    public function get()
    {
        return $this->_cart;
    }


    //del
    public function del($id)
    {
        unset($this->_cart[$id]);
        return $this;
    }

    //save
    public function save()
    {
        //1.得到cookie对象
        $cookies = \Yii::$app->response->cookies;
        //$cookies->expire=time()+3600;
        //2 发送相应 添加一个新的cookie
        $cookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => $this->_cart,
            'expire'=>time()+3600*24*7,
        ]));
    }

    //同步cookie数据到数据库
    public function synDb()
    {
        foreach ($this->_cart as $goodsId=>$amount){
            //判定当前商品在数据库中是否存在
            $userId=\Yii::$app->user->id;
            $cart=Cart::findOne(['goods_id'=>$goodsId,'user_id'=>$userId]);
            if($cart){
                //如果存在 修改
                $cart->amount+=$amount;
                $cart->save();
            }else{
                //新增
                $cart=new Cart();
                $cart->amount=$amount;
                $cart->goods_id=$goodsId;
                $cart->user_id=$userId;
                $cart->save();
            }
        }
    }

    //清空购物车
    public function flush()
    {
        $this->_cart=[];
        return $this;
    }

}