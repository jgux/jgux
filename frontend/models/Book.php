<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/19
 * Time: 18:21
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    //设置属性
    public $imgFile;
    public $code;
    //设置图片

    //设置规则
    public function rules()
    {
        return[
          [['price','sn','show','sug','author_id'],'required'],
          [['imgFile'],'image','extensions' =>"jpg,gif,png",'skipOnEmpty' => false],
        ];
    }

    //设置别名
    public function attributeLabels()
    {
        return[
          "price"=>"价格",
          "sn"=>"编号",
          "show"=>"是否上架",
          "sug"=>"书籍简介",
          "imgFile"=>"插入图片",
          "author_id"=>"作者编号",
          "code"=>"验证码"
        ];
    }

    //和作者变发生一对一关系
    public function getAuthor()
    {
        return $this->hasOne(Author::className(),["author_id"=>"author_id"]);
    }

}