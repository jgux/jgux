<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsCategory */
/* @var $form ActiveForm */
?>
<div class="goods-category-add">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'parent_id') ?>
        <?= $form->field($model, 'lft') ?>
        <?= $form->field($model, 'right') ?>
        <?= $form->field($model, 'level') ?>
        <?= $form->field($model, 'intro')->textarea() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-category-add -->
