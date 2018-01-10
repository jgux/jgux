<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $mobile
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    public $password;
    public $rePassword;
    public $checkcode;//验证码
    public $captcha;//手机验证
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','password','rePassword','mobile','captcha'], 'required'],
            //[['email'], 'unique'],
            ['rePassword','compare','compareAttribute'=>'password'],
            [['username'],'unique'],
            ['checkcode','captcha','captchaAction' => '/user/captcha']
            //[]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'email' => '邮箱',
            'mobile' => '手机号码',
            'status' => 'Status',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
