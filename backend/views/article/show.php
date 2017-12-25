<table class="table table-bordered">
    <tr>
        <td>id</td>
        <td>文章名称</td>
        <td>分类编号</td>
        <td>文章内容</td>
        <td>简介</td>
        <td>上架</td>
        <td>排序</td>
        <td>入库时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ($brands as $brand): ?>
        <tr>
            <td><?=$brand['id']?></td>
            <td><?=$brand['name']?></td>
            <td><?=$brand->category->name?></td>
            <td><?=\backend\models\Article::findOne($brand['id'])->detail->content?></td>
            <td><?=$brand['intro']?></td>
            <td><?=\Yii::$app->params['status'][$brand->status]?></td>
            <td><?=$brand['sort']?></td>
            <td><?=$brand['inputtime']?></td>
            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['display','id'=>$brand->id])?>" role="button">显示</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>