<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;
?>
<div class="row">
    <div class="pull-left">
        <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['add'])?>">添加</a>
    </div>
    <div class="pull-right">
        <!--<select>
            <option>请选择</option>
            <option>上架</option>y
            <option>下架</option>
        </select>-->
        <form class="form-inline">
            <select class="form-control" name="status">
                <option>选择状态</option>
                <option value="1" <?= Yii::$app->request->get("status")==='1'?"selected":'' ?>>上架</option>
                <option value="0" <?= Yii::$app->request->get("status")==='0'?"selected":'' ?>>下架</option>
            </select>
            <div class="form-group">
                <input type="text" class="form-control" size="4" name="minPrice"  placeholder="最低价" value="<?php Yii::$app->request->get('minPrice') ?>">
            </div>
            -
            <div class="form-group">
                <input type="text" class="form-control" size="4" name="maxPrice"  placeholder="最高价" value="<?php Yii::$app->request->get('maxPrice') ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="keyWord"   placeholder="请输入名称|货号" value="<?php Yii::$app->request->get('keyWord') ?>">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
        </form>
    </div>
</div>
<div class="table-responsive">
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
        <td>状态</td>
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
            <td><?=$model->status?></td>
            <td><?=$model->sort?></td>
            <td><?=$model->inputtime?></td>
            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['edit','id'=>$model->id])?>" role="button">编辑</a>
                <a class="btn btn-default" href="<?=\yii\helpers\Url::to(['goods-gallery/index','id'=>$model->id])?>" role="button">多图</a>
                <a class="btn btn-warning" href="<?=\yii\helpers\Url::to(['content','id'=>$model->id])?>" role="button">内容</a>
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['del','id'=>$model->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<?=LinkPager::widget([
    'pagination' => $pages,
]);?>
