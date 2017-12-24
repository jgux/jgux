<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form ActiveForm */
?>
<div class="article-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'sort')->textInput(["value"=>20]) ?>
        <?= $form->field($model, 'status')->radioList([1=>"上架",2=>"下架"],["value"=>1]) ?>
        <?= $form->field($model,'article_category_id')?>
        <?= $form->field($detail,'content')->textarea(["rows"=>10])?>
        <?= $form->field($model, 'intro') ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-add -->
