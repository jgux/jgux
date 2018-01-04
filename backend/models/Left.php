<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "left".
 *
 * @property integer $id
 * @property string $name
 * @property string $route
 * @property integer $parent_id
 */
class Left extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name', 'route'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'route' => '路由',
            'parent_id' => '父类id',
        ];
    }
}
