<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $detail
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property integer $pay_type_id
 * @property string $pay_type_name
 * @property string $price
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'delivery_id', 'pay_type_id', 'status', 'create_time'], 'integer'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'name' => '收货人',
            'province' => '省份',
            'city' => '城市',
            'area' => '区县',
            'detail' => '详细地址',
            'tel' => '手机号码',
            'delivery_id' => '配送方式Id',
            'delivery_name' => '配送方式的名字',
            'delivery_price' => '运费',
            'pay_type_id' => '支付方式Id',
            'pay_type_name' => '支付方式名字',
            'price' => '商品金额',
            'status' => '订单状态 0已取消 1代付款 2待发货 3待收货 4完成',
            'trade_no' => '第三方支付的交易号',
            'create_time' => 'Create Time',
        ];
    }
}
