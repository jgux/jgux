<?php
/* @var $this yii\web\View */
?>
<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['add'])?>">添加</a>
<a class="btn btn-danger" href="<?=\yii\helpers\Url::to([' reclaim'])?>">回收站</a>
<table class="table">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>货号</td>
        <td>图标</td>
        <td>商品分类</td>
        <td>品牌</td>
        <td>市场价格</td>
        <td>本店价格</td>
        <td>库存</td>
        <td>排序</td>
        <td>录入时间</td>
        <td>操作</td>

    </tr>
    <?php foreach($models as $model): ?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->sn?></td>
            <td><img src="<?=$model->logo?>" height="40"/></td>
            <td><?=$model->goods_category_id?></td>
            <td><?=$model->brand_id?></td>
            <td><?=$model->market_price?></td>
            <td><?=$model->shop_price?></td>
            <td><?=$model->stock?></td>
            <td><?=$model->sort?></td>
            <td><?=$model->inputtime?></td>
            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['edit','id'=>$model->id])?>" role="button">编辑</a>
                <a class="btn btn-default" href="<?=\yii\helpers\Url::to(['goods-gallery/add','id'=>$model->id])?>" role="button">多图</a>
                <a class="btn btn-warning" href="<?=\yii\helpers\Url::to(['content','id'=>$model->id])?>" role="button">内容</a>
                <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['callback','id'=>$model->id])?>" role="button">隐藏</a>
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['del','id'=>$model->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
