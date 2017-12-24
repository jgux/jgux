<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,"name");
echo $form->field($model,"password")->passwordInput();
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);
\yii\bootstrap\ActiveForm::end();
