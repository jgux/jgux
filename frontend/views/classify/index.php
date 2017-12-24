<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['classify/add'])?>">添加</a>
<table class="table">
    <tr>
        <td>id</td>
        <td>分类名称</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model): ?>
        <tr>
            <td><?=$model['id']?></td>
            <td><?=$model['goods_name']?></td>
            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['classify/edit','id'=>$model->id])?>" role="button">编辑</a>
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['classify/del','id'=>$model->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>