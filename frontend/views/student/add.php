<?php
//start
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($student,"name");
echo $form->field($student,"age");
echo \yii\bootstrap\Html::submitButton("提交",['class'=>"btn btn-info"]);
//end
\yii\bootstrap\ActiveForm::end();