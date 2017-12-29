<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form ActiveForm */
?>
<div class="goods-add">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'goods_category_id') ?>
    <?= \liyuze\ztree\ZTree::widget([
        'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id"
				}
			},
			callback:{
			    onClick:function(e,treeId,treeNode){
			        //console.dir(treeNode);
			        //1.找到父类Id
			         $("#goods-goods_category_id").val(treeNode.id);  
			    },
			    
			},
		}',
        'nodes' => $cates,

    ]);
    ?>
        <?= $form->field($model, 'brand_id')->dropDownList($brsArray) ?>
        <?= $form->field($model, 'stock') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'sort') ?>
        <?= $form->field($model, 'sn') ?>
        <?= $form->field($model, 'market_price') ?>
        <?= $form->field($model, 'shop_price') ?>
        <?= $form->field($model, 'logo')->widget('manks\FileInput', [
        ]);
        ?>
        <?=$form->field($goodsIntro,'content')->widget('kucha\ueditor\UEditor',[]);?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-add -->
<?php
$js=<<<EOF
    //console.dir(111);
    var treeObj = $.fn.zTree.getZTreeObj("w1");
    treeObj.expandAll(true);
    var nodes=treeObj.getNodeByParam("id","{$model->goods_category_id}", null);
    treeObj.selectNode(nodes);
EOF;
$this->registerJs($js);
?>