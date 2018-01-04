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
        <?= $form->field($model, 'password')->textInput(["value"=>""]) ?>
            <?php
            //条用组件
            $auth=Yii::$app->authManager;
            //得到所有的角色权限
            $roles=$auth->getRoles();
//            var_dump($roles);
//            循环获得权限
            foreach ($roles as $k => $role){
                //var_dump($k);
                            $model->roles[$k]=$role->name;
                        //var_dump($k);
                        }
                        //var_dump($model->roles[$k]);
             echo $form->field($model, 'roles')->dropDownList($model->roles);
            ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admin-add -->
