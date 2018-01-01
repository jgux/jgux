<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */
/* @var $form ActiveForm */
?>
<div class="admin-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'password') ?>
        <?= $form->field($model, 'email') ?>
            <?php
            //条用组件
            $auth=Yii::$app->authManager;
            //得到所有的角色权限
            $roles=$auth->getRoles();
            //循环获得权限
            foreach ($roles as $role){
                $model->roles[]=$role->name;
            }
            echo $form->field($model, 'roles')->dropDownList($model->roles);
            ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admin-add -->
