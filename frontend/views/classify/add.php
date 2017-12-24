<?php
//start
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($models,"id");
echo $form->field($models,"goods_name");
echo \yii\bootstrap\Html::submitButton("提交",['class'=>"btn btn-info"]);
//end
\yii\bootstrap\ActiveForm::end();