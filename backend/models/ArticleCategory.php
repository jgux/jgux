<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $is_help
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro','status','sort','is_help','name'], 'required'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名称',
            'intro' => '简介@textarea',
            'status' => '状态@radio|1=是&2=否',
            'sort' => '排序',
            'is_help' => '是否是帮助相关的分类',
        ];
    }
    public function getHelp(){
        if ($this->is_help == 1){
            return '是';
        }else{
            return '否';
        }
    }
}
