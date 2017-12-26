<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['add'])?>">添加</a>
<!--<a class="btn btn-success" href="<?/*=\yii\helpers\Url::to(['show'])*/?>">回收站</a>-->
<table class="table table-bordered">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>左值</td>
        <td>右值</td>
        <td>parent_id</td>
        <td>深度</td>
        <td>树</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model): ?>
        <tr>
            <td><?=$model['id']?></td>
            <td><?=$model['name']?></td>
            <td><?=$model['lft']?></td>
            <td><?=$model['rgt']?></td>
            <td><?=$model['parent_id']?></td>
            <td><?=$model['depth']?></td>
            <td><?=$model['tree']?></td>
            <td><?=$model['intro']?></td>

            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['edit','id'=>$model->id])?>" role="button">编辑</a>
                <!--<a class="btn btn-success" href="<?/*=\yii\helpers\Url::to(['callback','id'=>$model->id])*/?>" role="button">隐藏</a>-->
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['del','id'=>$model->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>



