<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $goods_id
 * @property string $goods_name
 * @property integer $amount
 * @property string $logo
 * @property string $price
 * @property string $total_price
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id', 'amount'], 'integer'],
            [['price', 'total_price'], 'number'],
            [['goods_name', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id',
            'goods_id' => '商品id',
            'goods_name' => '商品名称',
            'amount' => '商品数量',
            'logo' => '图片',
            'price' => '单价',
            'total_price' => '总金额',
        ];
    }
}
