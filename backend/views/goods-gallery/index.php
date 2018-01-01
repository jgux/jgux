<?php
/* @var $this yii\web\View */
?>
<h1>商品多图表</h1>

<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['goods/index'])?>">返回商品列表</a>
<table class="table">
    <tr>
        <td>id</td>
        <td>商品id</td>
        <td>图片地址</td>
    </tr>
    <?php foreach ($models as $model): ?>
    <tr>
        <td><?=$model['id']?></td>
        <td><?=$model['goods_id']?></td>
        <td><img src="<?= $model['path'] ?>" height="40"></td>

    </tr>
    <?php endforeach; ?>
</table>

