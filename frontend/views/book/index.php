<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['add'])?>">添加</a>
<table class="table">
    <tr>
        <td>id</td>
        <td>书籍价格</td>
        <td>编号</td>
        <td>是否上架</td>
        <td>书籍简介</td>
        <td>缩略图</td>
        <td>作者编号</td>
        <td>作者</td>
        <td>作者电话</td>
        <td>创作时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model): ?>
        <tr>
            <td><?=$model['id']?></td>
            <td><?=$model['price']?></td>
            <td><?=$model['sn']?></td>
            <td><?=$model['show']?></td>
            <td><?=$model['sug']?></td>
            <td><?=\yii\bootstrap\Html::img("/".$model->img,["height"=>40])?></td>
            <td><?=$model['author_id']?></td>
            <td><?=$model->author->author?></td>
            <td><?=$model->author->phone?></td>
            <td><?=$model['time']?></td>
            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['edit','id'=>$model->id])?>" role="button">编辑</a>
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['del','id'=>$model->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?=\yii\widgets\LinkPager::widget([
    'pagination' => $pag
])
?>
