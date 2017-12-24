<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['student/add'])?>">添加</a>
<table class="table">
    <tr>
        <td>id</td>
        <td>姓名</td>
        <td>年龄</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model): ?>
        <tr>
            <td><?=$model['id']?></td>
            <td><?=$model['name']?></td>
            <td><?=$model['age']?></td>
            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['student/edit','id'=>$model->id])?>" role="button">编辑</a>
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['student/del','id'=>$model->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>