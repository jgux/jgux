<?php
/* @var $this yii\web\View */
?>

<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['goods/index'])?>">返回商品列表</a>
<table class="table-bordered">
    <tr>
        <td>商品内容详情</td>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->content?></td>
    </tr>
    <?php endforeach; ?>
</table>