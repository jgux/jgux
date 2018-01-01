<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn新字段
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $status
 * @property integer $sort
 * @property string $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    public $imgFile;//用来存储多图
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_category_id', 'brand_id', 'stock', 'status', 'sort','name','market_price','shop_price'], 'required'],
            [['logo','imgFile'],'safe'],
            [['sn'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sn' => '货号|不写会自动生成',
            'logo' => '商品LOGO',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'status' => '1正常0回收站',
            'sort' => '排序',
            'inputtime' => '录入时间',
            'imgfile'=>'多图上传',
        ];
    }


}
