<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['goods/add'])?>" role="button">添加</a>
<table class="table">
    <tr>
        <td>id</td>
        <td>商品名称</td>
        <td>商品编号</td>
        <td>商品价格</td>
        <td>商品库存</td>
        <td>商品分类</td>
        <td>商品简介</td>
        <td>添加时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ($goods as $good): ?>
    <tr>
        <td><?=$good['id']?></td>
        <td><?=$good['name']?></td>
        <td><?=$good['sn']?></td>
        <td><?=$good['price']?></td>
        <td><?=$good['total']?></td>
        <td><?=\frontend\models\Goods::findOne($good['id'])->classify->goods_name?></td>
        <td><?=$good['detail']?></td>
        <td><?=$good['create_time']?></td>
        <td>
            <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['goods/edit','id'=>$good->id])?>" role="button">编辑</a>
            <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['goods/del','id'=>$good->id])?>" role="button">删除</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>