<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form ActiveForm */
?>
<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['index'])?>">回到列表页</a>
<div class="category-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'parent_id')?>
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
			         $("#category-parent_id").val(treeNode.id);  
			    },
			    
			},
		}',
        'nodes' => $cates,

    ]);
    ?>
        <?= $form->field($model, 'intro') ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
    $js=<<<EOF
    //console.dir(111);
    var treeObj = $.fn.zTree.getZTreeObj("w1");
    treeObj.expandAll(true);
    
EOF;
    $this->registerJs($js);
?>

