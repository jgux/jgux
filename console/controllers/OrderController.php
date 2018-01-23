<?php

namespace console\controllers;

use backend\models\Goods;
use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;
use EasyWeChat\Foundation\Application;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\console\Controller;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    //清除超时未支付的订单
    public function actionClear()
    {
        while (true){
            //1 找出 超时 未支付 time()-150*60>创建时间 就是超时单了
            //创建时间<time()-5;
            $order=Order::find()->where(['status'=>1])->andWhere(['<','create_time',time()-10])->asArray()->all();
            //2 提取所有要取消的订单的id
            $orderIds=array_column($order,'id');
            var_dump($orderIds);
            //3 修改超时未支付订单的状态-1-0 取消
            Order::updateAll(['status'=>0],['in','id',$orderIds]);
            //4 根据id找出所有的order_detail里的商品 还原库存
            foreach ($orderIds as $orderId){//订单表和订单详情表示一对多的关系
                //根据id找到对应的商品
                $orderGoods=OrderDetail::find()->where(['order_id'=>$orderId])->all();
                //还原库存
                foreach ($orderGoods as $orderGood){
                    Goods::updateAllCounters(['stock'=>$orderGood->amount],['id'=>$orderGood->goods_id]);
                }
            }
            //判定是否有超时未支付的订单
            if($orderIds){//存在 未处理的订单号在输出
                echo implode(",",$orderIds)."complete ok".PHP_EOL;//输出提示语 implode 是数组转字符串 ，php_eol 是/n 回车
            }
            sleep(5);

        }

    }


    
}
