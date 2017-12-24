<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['add'])?>">添加</a>
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
    <?php foreach ($models as $model): ?>
        <tr>
            <td><?=$model['id']?></td>
            <td><?=$model['name']?></td>
            <td><?=$model['article_category_id']?></td>
            <td><?=\backend\models\Article::findOne($model['id'])->detail->content?></td>
            <td><?=$model['intro']?></td>
            <td><?=\Yii::$app->params['status'][$model->status]?></td>
            <td><?=$model['sort']?></td>
            <td><?=$model['inputtime']?></td>
            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['edit','id'=>$model->id])?>" role="button">编辑</a>
                <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['callback','id'=>$model->id])?>" role="button">回收站</a>
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['del','id'=>$model->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>





