<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

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
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;
    public $rePassword;
    public $checkcode;//验证码
    public $captcha;//手机验证
    public $rememberMe;//记住我
    /**
     * @inheritdoc
     */
   //场景
    public function scenarios()
    {
        $scenarios=parent::scenarios();

        $scenarios['login'] = ['username','password','rememberMe'];
        $scenarios['reg']=['username','password','rePassword','captcha','checkCode','mobile'];
        return $scenarios;
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
            [['username'],'unique','on' => 'reg'],
            [['mobile'],'match','pattern'=>'/^[1][34578][0-9]{9}$/','message' => '手机号不正确'],
            ['checkcode','captcha','captchaAction' => '/user/captcha'],
           // [['captcha'],'validateCaptcha'],//自定义
            [['rememberMe'],'safe','on'=>'login']
        ];
    }

    //$attribute 就是 属性值
    public function validateCaptcha($attribute, $params)
    {
        //1. 根据手机号得到对应的Session值
        $code = Yii::$app->session->get('tel_' . $this->mobile);
        //2. 根据当前验证码是否和session值一琶
        if ($code != $this->captcha) {
            //3.添加错误提示
            $this->addError($attribute, "验证码错误");
        }
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

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key===$authKey;
    }
}
