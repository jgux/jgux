<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/31
 * Time: 21:10
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    public function rules()
    {
        return[
            [['username','password'],'required'],
            [['rememberMe'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>"用户名",
            'password'=>"密码"
        ];
    }
}