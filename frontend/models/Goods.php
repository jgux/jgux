<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/14
 * Time: 19:34
 */
namespace frontend\models;
use yii\db\ActiveRecord;
class Goods extends ActiveRecord
{
    //1设置属性->表单模型才写！ 数据模型不写

    //2设置规则
    public function rules()
    {
        return[
          [['name','sn','price','total','detail'],'required'],
          [['sn'],'safe'],
          [['price'],'safe'],
          [['total'],'safe'],
          [['detail'],'safe'],
          [['create_time'],'safe'],

        ];
    }
    //3设置label
    public function attributeLabels()
    {
        return [
            'name' => '商品名称',
            'sn' => '商品编号',
            'price' => '商品价格',
            'total' => '商品库存',
            'detail' => '商品简介',
            'create_time' => '商品添加时间',
        ];
    }

    public function getClassify()
    {
        return $this->hasOne(GoodsClassify::className(),["id"=>"sn"]);
    }
    
}