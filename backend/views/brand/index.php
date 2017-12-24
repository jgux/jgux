<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['add'])?>">添加</a>
<table class="table table-bordered">
    <tr>
        <td>id</td>
        <td>品牌名</td>
        <td>商标</td>
        <td>排序</td>
        <td>是否上架</td>
        <td>描述</td>
        <td>操作</td>
    </tr>
    <?php foreach ($brands as $brand): ?>
        <tr>
            <td><?=$brand['id']?></td>
            <td><?=$brand['name']?></td>
            <td><?=\yii\bootstrap\Html::img("/".$brand->img,["height"=>40])?></td>
            <td><?=$brand['sort']?></td>
            <td><?=\Yii::$app->params['status'][$brand->status]?></td>
            <td><?=$brand['intro']?></td>
            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['edit','id'=>$brand->id])?>" role="button">编辑</a>
                <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['callback','id'=>$brand->id])?>" role="button">回收站</a>
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['del','id'=>$brand->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


