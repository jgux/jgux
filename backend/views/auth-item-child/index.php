<?php
/* @var $this yii\web\View */
?>
<h1>角色列表</h1>
<table class="table">
    <tr>
        <th>角色名称</th>
        <th>角色描述</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php foreach ($roles as $role): ?>
        <tr>
            <td><?=$role->name?></td>
            <td><?=$role->description?></td>
            <td>
                <?php
                //条用组件
                $auth=Yii::$app->authManager;
                //得到所有的角色权限
                $pres=$auth->getPermissionsByRole($role->name);
                //循环获得权限
                foreach ($pres as $pre){
                    echo $pre->description."--";
                }
                ?>
            </td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','name'=>$role->name])?>" class="btn btn-info">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['del','name'=>$role->name])?>" class="btn btn-info">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

