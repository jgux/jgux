<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/18
 * Time: 18:51
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class GoodsClassify extends ActiveRecord
{
    //1表单模型设置属性
    //2设置规则
    public function rules()
    {
        return[
          [["goods_name","id"],"required"],
          [["id"],"integer"]
        ];
    }
    //3设置别名
    public function attributeLabels()
    {
        return [
            "goods_name"=>"分类名称",
            "id"=>"商品编号",
        ];
    }

    //1对多
    public function getGoods()
    {
        return $this->hasMany(Goods::className(),["sn"=>"id"]);
    }

}