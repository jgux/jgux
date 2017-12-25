<?php

namespace backend\models;

use Yii;
use yii\rbac\Item;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Article extends \yii\db\ActiveRecord
{
    //声明一个临时变量来存储文章内容
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','status','sort','article_category_id'],'required'],
            [['intro','inputtime'],'safe'],
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
            'article_category_id' => '文章分类',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
            'articleContent'=>'文章内容'
        ];
    }


    //关联文章内容表查询 -关联查询技术
    public function getDetail()
    {
        return $this->hasOne(ArticleDetail::className(),['article_id'=>'id']);
    }

    //关联文章分类表查询 1-1
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }
}
