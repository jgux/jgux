<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                 <?php if (Yii::$app->user->isGuest){
                     echo "<p>";
                      echo "请登录";
                     echo "</p>";
                     echo  "<a href='#'><i class='fa fa-circle text-danger'></i> Offline</a>";
                  }else{
                     echo "<p>";
                    echo "欢迎您".Yii::$app->user->identity->username;
                     echo "</p>";
                  echo  "<a href='#'><i class='fa fa-circle text-success'></i> Online</a>";
                  } ?>


            </div>
        </div>

        <!--search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->
        <?php
            $newMenus = [];
            $models=\backend\models\Left::find()->where(["parent_id" => 0])->all();
            //循环得到一级分类
             foreach ($models as $model){
                 //分别赋值
                 $newMenu = [
                   'label'=>$model->name,
                   'url'=>'#',
                 ];
                 //第二次循环得到二级分类
                 foreach (\backend\models\Left::find()->where(["parent_id"=>$model->id])->all() as $v){
                    //给二级分类赋值
                     $newMenu['items'][]=[
                         'label' => $v->name,
                         'url' => [$v->route],
                     ];

                 }

                 //把一级分类追加到数组中
                 $newMenus[]=$newMenu;

            }

        ?>

<?php
use mdm\admin\components\MenuHelper;
$callback = function($menu){
    $data = json_decode($menu['data'], true);
    $items = $menu['children'];
    $return = [
        'label' => $menu['name'],
        'url' => [$menu['route']],
    ];
    //处理我们的配置
    if ($data) {
        //visible
        isset($data['visible']) && $return['visible'] = $data['visible'];
        //icon
        isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
        //other attribute e.g. class...
        $return['options'] = $data;
    }
    //没配置图标的显示默认图标
    (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
    $items && $return['items'] = $items;
    return $return;
};


echo dmstr\widgets\Menu::widget(
    [
        'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
        'items' => mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->identity->id,null, $callback),
    ]

) ?>


    </section>

</aside>


