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
        <td><img src="<?=$brand->img?>"></td>
        <td><?=$brand['sort']?></td>
        <td><?=\Yii::$app->params['status'][$brand->status]?></td>
        <td><?=$brand['intro']?></td>
        <td><a class="btn btn-info" href="<?=\yii\helpers\Url::to(['display','id'=>$brand->id])?>" role="button">显示</a></td>

    <?php endforeach;?>
    </tr>
</table>