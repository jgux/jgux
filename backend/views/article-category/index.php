<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['add'])?>">添加</a>
<table class="table table-bordered">
    <tr>
        <td>id</td>
        <td>分类名称</td>
        <td>描述</td>
        <td>状态</td>
        <td>排序</td>
        <td>是否是帮助分类</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model): ?>
        <tr>
            <td><?=$model['id']?></td>
            <td><?=$model['name']?></td>
            <td><?=$model['intro']?></td>
            <td><?=Yii::$app->params['status'][$model->status]?></td>
            <td><?=$model['sort']?></td>
            <td><?=$model->help?></td>
            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['edit','id'=>$model->id])?>" role="button">编辑</a>

                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['del','id'=>$model->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


