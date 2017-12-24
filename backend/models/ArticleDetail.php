<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/23
 * Time: 19:20
 */

namespace backend\models;


use yii\db\ActiveRecord;

class ArticleDetail extends ActiveRecord
{
    //设置规则
    public function rules()
    {
        return[
          [['content','article_id'],'required'],
        ];
    }
    //设置别名
    public function attributeLabels()
    {
        return [
          "content"=>'文章内容'
        ];
    }
}