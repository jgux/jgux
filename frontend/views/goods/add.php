<?php
//开启 ActiveForm
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($goods,"name");
echo $form->field($goods,'sn');
echo $form->field($goods,'price');
echo $form->field($goods,'total');
echo $form->field($goods,'detail')->textarea(["clos"=>10,'rows'=>20]);
//提交按钮单独设置
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);
\yii\bootstrap\ActiveForm::end();
//结束 activeForm

