<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,"price");
echo $form->field($model,"sn");
echo $form->field($model,"show")->dropDownList(
    \frontend\models\Book::find()->select(['show','id'])->indexBy('show')->column(),
    ['prompt'=>'请选择商品状态']
);
echo $form->field($model,"sug");
echo $form->field($model,"author_id")->dropDownList($authorArray);
echo $form->field($model,"imgFile")->fileInput();
echo $form->field($model,"code")->widget(
    yii\captcha\Captcha::className(),[
        'captchaAction' => 'book/captcha',
        'template' =>'<div class="row"><div class="col-lg-1">{input}</div><div class="col-lg-1">{image}</div></div>',
    ]
);
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);
\yii\bootstrap\ActiveForm::end();