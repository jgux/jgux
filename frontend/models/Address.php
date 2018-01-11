<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $detailed
 * @property string $phone
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $province3;
    public $city3;
    public $area3;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','phone','detailed'],'required'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户表id',
            'username' => '姓名',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'detailed' => '详细地址',
            'phone' => '手机号',
        ];
    }

    //关联查询


}
