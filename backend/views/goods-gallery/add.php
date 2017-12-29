<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsGallery */
/* @var $form ActiveForm */
?>
<div class="goods-gallery-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'goods_id')->textInput(['value'=>$id])?>
    <?php
    // ActiveForm 多图
    echo $form->field($model, 'path')->widget('manks\FileInput', [
        'clientOptions' => [
            'pick' => [
                'multiple' => true,
            ],
            // 'server' => Url::to('upload/u2'),
            // 'accept' => [
            // 	'extensions' => 'png',
            // ],
        ],
    ]); ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-gallery-add -->
