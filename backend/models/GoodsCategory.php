<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $lft
 * @property integer $right
 * @property integer $level
 * @property string $intro
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'lft', 'right', 'level','name'], 'required'],
            [['intro'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'parent_id' => '父分类',
            'lft' => '左边界',
            'right' => '右边界',
            'level' => '级别',
            'intro' => '简介@textarea',
        ];
    }
}
