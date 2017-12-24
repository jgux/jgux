<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $img
 * @property integer $sort
 * @property integer $status
 * @property string $intro
 */
class Brand extends \yii\db\ActiveRecord
{
    //设置临时图片属性
    public $imgFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','sort', 'status'],'required'],
            [['sort', 'status'], 'integer'],
            [['intro'],'safe'],
            [['imgFile'],'file','skipOnEmpty' =>true,'extensions' => 'jpg,png,gif' ],
            [['img','reclaim'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名',
            'imgFile' => '商标',
            'sort' => '排序',
            'status' => '1:上架,2:下架',
            'intro' => '描述',
        ];
    }
}
