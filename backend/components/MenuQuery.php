<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/26
 * Time: 11:44
 */

namespace backend\components;


use creocoder\nestedsets\NestedSetsQueryBehavior;

class MenuQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}