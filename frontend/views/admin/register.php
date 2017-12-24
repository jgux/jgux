<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,"name");
echo $form->field($model,"password")->passwordInput();
echo $form->field($model,"age");
echo $form->field($model,"sex")->inline()->radioList(Yii::$app->params["sex"]);
echo $form->field($model,"imgFile")->fileInput();
echo $form->field($model,"code")->widget(
    yii\captcha\Captcha::className(),[
        'captchaAction' => 'book/captcha',
        'template' =>'<div class="row"><div class="col-lg-1">{input}</div><div class="col-lg-1">{image}</div></div>',
    ]
);

echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-danger"]);
\yii\bootstrap\ActiveForm::end();