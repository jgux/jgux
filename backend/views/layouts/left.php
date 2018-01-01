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
                     echo  "<a href='#'><i class='fa fa-circle text-danger'></i> Online</a>";
                  }else{
                     echo "<p>";
                    echo Yii::$app->user->identity->username;
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

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => '后台管理', 'options' => ['class' => 'header']],
                    ['label' => '品牌', 'icon' => 'fa fa-handshake-o', 'url' => ['/brand/index'],],
                    ['label' => '添加用户', 'icon' => 'fighter-jet', 'url' => ['/admin/add'],],
                    /*[
                        'label' => '管理员',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '登录', 'icon' => 'hand-pointer-o', 'url' => ['/admin/login'],],
                            ['label' => '退出', 'icon' => 'fighter-jet', 'url' => ['/admin/logout'],],
                        ],
                    ],*/
                    [
                        'label' => '权限管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '权限列表', 'icon' => 'hand-pointer-o', 'url' => ['/auth-assignment/index'],],
                            ['label' => '添加权限', 'icon' => 'fighter-jet', 'url' => ['/auth-assignment/add'],],
                        ],
                    ],
                    [
                        'label' => '组管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '组列表', 'icon' => 'hand-pointer-o', 'url' => ['/auth-item-child/index'],],
                            ['label' => '添加组', 'icon' => 'fighter-jet', 'url' => ['/auth-item-child/add'],],
                        ],
                    ],
                    [
                        'label' => '商品管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '商品列表', 'icon' => 'hand-pointer-o', 'url' => ['/goods/index'],],
                            ['label' => '商品分类', 'icon' => 'fighter-jet', 'url' => ['/category/index'],],
                        ],
                    ],
                    //文章
                    [
                        'label' => '文章整理',
                        'icon' => 'suitcase',
                        'url' => '#',
                        'items' => [
                            ['label' => '文章', 'icon' => 'taxi', 'url' => ['/article/index'],],
                            ['label' => '新闻', 'icon' => 'shopping-basket', 'url' => ['/article-category/index'],],
                        ],
                    ],
                    //文章 end
                ],
            ]
        ) ?>

    </section>

</aside>
