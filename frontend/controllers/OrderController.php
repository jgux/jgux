<?php

namespace frontend\controllers;

use backend\models\Goods;
use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;
use EasyWeChat\Foundation\Application;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class OrderController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {

        $user_id=\Yii::$app->user->identity->id;
        $carts=Cart::find()->where(['user_id'=>$user_id])->asArray()->all();
        $goods=[];
        $totalPrice=0;
        foreach ($carts as $k=>$v){
            $good=Goods::find()->where(['id'=>$v['goods_id']])->asArray()->one();
            $good['num']=$v['amount'];
            $totalPrice+=$good['shop_price']*$good['num'];
            $goods[]=$good;
        }
        //var_dump($carts);
        //1.2 取出所有的Id
        /*$goodIds=array_column($carts,"goods_id");
        $goodNum=ArrayHelper::map($carts,'goods_id','amount');
        //1.3获取所有的商品
        $goods=Goods::find()->where(['in',"id",$goodIds])->asArray()->all();
        //总价
        $totalPrice=0;
        foreach ($goods as $k=>$good){
            $goods[$k]['num']=$goodNum[$good['id']];
            $totalPrice=$goods[$k]['shop_price']*$goodNum[$good['id']];
        }*/
        //var_dump($totalPrice);exit;
        //获取当前用户设置的地址
        $address=Address::find()->where(['status'=>1,'user_id'=>$user_id])->asArray()->all();
        //var_dump($goods);exit;
        //接收数据
        $request=\Yii::$app->request;
        if($request->isPost){
            //var_dump($request->post());exit;
            //开启事务
            $db=\Yii::$app->db;
            $transaction=$db->beginTransaction();
            try{
                $order=new Order();

                //地址
                $adr=Address::findOne($request->post('address_id'));
                $order->user_id=$user_id;
                $order->name=$adr->username;
                $order->province=$adr->province;
                $order->city=$adr->city;
                $order->area=$adr->area;
                $order->detail=$adr->detailed;
                $order->tel=$adr->phone;
                //送货方式
                $order->delivery_id=$request->post("delivery_id");
                $order->delivery_name=\Yii::$app->params["delivers"][ $order->delivery_id - 1]["delivery_name"];//减一是数组的原因
                $order->delivery_price=\Yii::$app->params["delivers"][ $order->delivery_id - 1]["delivery_price"];//减一是数组的原因
                //支付方式
                $order->pay_type_id=$request->post('pay_type_id');
                $order->pay_type_name=\Yii::$app->params['payType'][ $order->pay_type_id -1]['pay_type_name'];
                $order->status=1;
                $order->trade_no=date("ymdHis").rand(1000,9999);//生成商品唯一订单号
                $order->create_time=time();
                //总价
                $order->price=$totalPrice +$order->delivery_price; //+运费

                //var_dump($order);exit;
                $order->save();
                //判定商品数量是否足够
                foreach ($goods as $good){
                    $goodsModel=Goods::findOne($good['id']);
                    //
                    if($good['num']>$goodsModel->stock){
                        throw new Exception("库存不足,请从新下单");//抛出异常
                    }
                    //下单成功 保存数据
                    $orderDetail=new OrderDetail();
                    $orderDetail->order_id = $order->id;//订单Id
                    $orderDetail->goods_id = $good['id'];
                    $orderDetail->amount = $good['num'];
                    $orderDetail->goods_name = $good['name'];
                    $orderDetail->logo = $good['logo'];
                    $orderDetail->price = $good['shop_price'];
                    $orderDetail->total_price = $good['shop_price'] * $good['num'];
                    //var_dump($orderDetail);exit;
                    $orderDetail->save();
                    //减库存
                    $goodsModel->stock -= $good['num'];
                    $goodsModel->save();
                }
                //清空购物车
                Cart::deleteAll(['user_id'=>$user_id]);
                $transaction->commit();//提交事务


            }catch (Exception $exception){
                $transaction->rollBack();//事务回滚
                echo "<script>alert('" . $exception->getMessage() . "')</script>";//得到异常
            }

            return $this->render('qrcode', ['id' => $order->id]);
        }



        return $this->render('index',compact('goods','address'));
    }

    public function actionWxPay($id)
    {
        //查出订单
        $goodsOrder=Order::findOne($id);

        //var_dump($goodsOrder->trade_no);exit;
        $app = new Application(\Yii::$app->params['easyWechat']);
        $payment = $app->payment;
    //use EasyWeChat\Payment\Order;

        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => 'hello word',//微信头部
            'detail'           => 'make',
            'out_trade_no'     => $goodsOrder->trade_no,//订单编号
            'total_fee'        => 1, // 单位：分
            'notify_url'       =>Url::to(['order/notify'],true),// 支付结果通知网址，如果不设置则会使用配置里的默认地址
            //'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];

        $order =new \EasyWeChat\Payment\Order($attributes);

        $result = $payment->prepare($order);
        //var_dump($result);exit;
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            //$prepayId = $result->prepay_id;
            //echo $result->code_url; 得到返回的wx链接地址
            return QrCode::png($result->code_url,false,Enum::QR_ECLEVEL_H,6);//生成二维码

        }else{
            var_dump($result);exit;
        }

    }

    //调用二维码的方法
    public function actionQrcode($id)
    {
        return $this->render('qrcode',compact('id'));
    }

    //order-notify
    public function actionNotify()
    {
        //easywechat全局对象
        $app = new Application(\Yii::$app->params['easyWechat']);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = Order::findOne(["trade_no"=>$notify->out_trade_no]);

            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status!=1) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                //$order->paid_at = time(); // 更新支付时间为当前时间
                $order->status =2;
            }
            $order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;
    }


    
}
