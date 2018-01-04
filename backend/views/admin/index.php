<?php
/* @var $this yii\web\View */
?>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info">添加用户</a>
<h1>管理员列表</h1>
<table class="table">
    <tr>
        <th>用户名</th>
        <th>创建时间</th>
        <th>最后登录时间</th>
        <th>令牌</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model): ?>
        <tr>
            <td><?=$model->username?></td>
            <td><?=$model->created_at?></td>
            <td><?=$model->last_login_ip?></td>
            <td><?=$model->auth_key?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$model->id])?>" class="btn btn-info">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$model->id])?>" class="btn btn-info">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

