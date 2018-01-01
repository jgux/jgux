<?php
/* @var $this yii\web\View */
?>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-info">添加</a>
<h1>权限管理</h1>
<table>
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>操作</th>
    </tr>
    <?php foreach ($permissions as $permission):?>
        <tr>
            <td>
                <?=$permission->name?>
            </td>
            <td>
                <?=$permission->description?>
            </td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','name'=>$permission->name])?>" class="btn btn-info">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['del','name'=>$permission->name])?>" class="btn btn-info">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

