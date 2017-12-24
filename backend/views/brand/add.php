<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,"name");
echo $form->field($model,"sort")->textInput(["value"=>100]);
echo $form->field($model,"status")->inline()->radioList([1=>"yes",2=>"no"],["value"=>1]);
echo $form->field($model,"intro")->textarea();
echo $form->field($model, 'img')->widget('manks\FileInput', [
]);

echo \yii\bootstrap\Html::submitButton("提交",["btn btn-info"]);
\yii\bootstrap\ActiveForm::end();
