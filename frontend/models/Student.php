<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/18
 * Time: 17:42
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class Student extends ActiveRecord
{
    //1.设置属性
    //2.设置规则
    public function rules()
    {
        return [
            [['name','age'],"required"],
            [['age'],"integer"],
        ];
    }

    //2.设置别名
    public function attributeLabels()
    {
        return[
          "name"=>"姓名",
            "age"=>"年龄"
        ];
    }
}