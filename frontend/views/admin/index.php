<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['admin/login'])?>" role="button">登录</a>
<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['admin/register'])?>" role="button">注册</a>

<table class="table">
    <tr>
        <th>id</th>
        <th>用户名</th>
        <th>密码</th>
        <th>年龄</th>
        <th>性别</th>
        <th>头像</th>
    </tr>
    <?php foreach ($models as $model): ?>
        <tr>
            <th><?=$model->id?></th>
            <th><?=$model->name?></th>
            <th><?=$model->password?></th>
            <th><?=$model->age?></th>
            <th><?= Yii::$app->params['sex'][$model->sex]?></th>
            <th><?=\yii\bootstrap\Html::img("/".$model->img,["height"=>40])?></th>
        </tr>
    <?php endforeach;?>
</table>



