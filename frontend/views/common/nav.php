<div class="header w1210 bc mt15">
    <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
    <div class="logo w1210">
        <h1 class="fl"><a href="index.html"><img src="/regist/images/logo.png" alt="京西商城"></a></h1>
        <!-- 头部搜索 start -->
        <div class="search fl">
            <div class="search_form">
                <div class="form_left fl"></div>
                <form action="" name="serarch" method="get" class="fl">
                    <input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
                </form>
                <div class="form_right fl"></div>
            </div>

            <div style="clear:both;"></div>

            <div class="hot_search">
                <strong>热门搜索:</strong>
                <a href="">D-Link无线路由</a>
                <a href="">休闲男鞋</a>
                <a href="">TCL空调</a>
                <a href="">耐克篮球鞋</a>
            </div>
        </div>
        <!-- 头部搜索 end -->

        <!-- 用户中心 start-->
        <div class="user fl">
            <dl>
                <dt>
                    <em></em>
                    <a href="">用户中心</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        您好，请<a href="">登录</a>
                    </div>
                    <div class="uclist mt10">
                        <ul class="list1 fl">
                            <li><a href="">用户信息></a></li>
                            <li><a href="">我的订单></a></li>
                            <li><a href="">收货地址></a></li>
                            <li><a href="">我的收藏></a></li>
                        </ul>

                        <ul class="fl">
                            <li><a href="">我的留言></a></li>
                            <li><a href="">我的红包></a></li>
                            <li><a href="">我的评论></a></li>
                            <li><a href="">资金管理></a></li>
                        </ul>

                    </div>
                    <div style="clear:both;"></div>
                    <div class="viewlist mt10">
                        <h3>最近浏览的商品：</h3>
                        <ul>
                            <li><a href=""><img src="/regist/images/view_list1.jpg" alt="" /></a></li>
                            <li><a href=""><img src="/regist/images/view_list2.jpg" alt="" /></a></li>
                            <li><a href=""><img src="/regist/images/view_list3.jpg" alt="" /></a></li>
                        </ul>
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 用户中心 end-->

        <!-- 购物车 start -->
        <div class="cart fl">
            <dl>
                <dt>
                    <a href="">去购物车结算</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        购物车中还没有商品，赶紧选购吧！
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 购物车 end -->
    </div>
    <!-- 头部上半部分 end -->

    <div style="clear:both;"></div>

    <?php ob_start() //开启缓存?>
    <!-- 导航条部分 start -->
    <div class="nav w1210 bc mt10">
        <!--  商品分类部分 start-->
        <div class="category fl <?=\Yii::$app->controller->id."/".\Yii::$app->controller->action->id=='index/index'?"":"cat1"?>"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd off">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>

            <div class="cat_bd <?=\Yii::$app->controller->id."/".\Yii::$app->controller->action->id=='index/index'?"":"none"?>">
                <?php foreach (\backend\models\Category::find()->where(["parent_id"=>0])->all() as $k1=>$v1): ?>
                    <div class="cat <?=$k1==0?"iteml":""?>">
                        <h3><a href="<?=\yii\helpers\Url::to(['goods/lists','id'=>$v1->id])?>"><?=$v1->name?></a> <b></b></h3>
                        <div class="cat_detail">

                            <?php foreach (\backend\models\Category::find()->where(["parent_id"=>$v1->id])->all() as $k2=>$v2): ?>
                                <dl class="<?=$k2==0?"dl_1st":""?>">
                                    <dt><a href="<?=\yii\helpers\Url::to(['goods/lists','id'=>$v2->id])?>"><?=$v2->name?></a></dt>
                                    <dd>
                                        <?php foreach (\backend\models\Category::find()->where(["parent_id"=>$v2->id])->all() as $k3=>$v3): ?>

                                            <a href="<?=\yii\helpers\Url::to(['goods/lists','id'=>$v3->id])?>"><?=$v3->name?></a>
                                        <?php endforeach; ?>
                                    </dd>
                                </dl>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>


            </div>

        </div>
        <!--  商品分类部分 end-->

        <div class="navitems fl">
            <ul class="fl">
                <li class="current"><a href="<?=\yii\helpers\Url::to(['index/index'])?>">首页</a></li>
                <li><a href="">电脑频道</a></li>
                <li><a href="">家用电器</a></li>
                <li><a href="">品牌大全</a></li>
                <li><a href="">团购</a></li>
                <li><a href="">积分商城</a></li>
                <li><a href="">夺宝奇兵</a></li>
            </ul>
            <div class="right_corner fl"></div>
        </div>
    </div>
    <!-- 导航条部分 end -->
    <?php
        $html=ob_get_clean() ;//得到缓存 ob_get_clean()与ob_get_contents()的区别
        //存入缓存
    //首页和其他页面不一样 首页最开始要展示出来 其他的不会 所以要分开缓存
    $cacheName=\Yii::$app->controller->id."/".\Yii::$app->controller->action->id=='index/index'?"index":"list";

    //Yii::$app->cache->set('category',$html);//使用yii自带的文件缓存 存入缓存
        //判定有没有文件缓存
    if (Yii::$app->cache->get($cacheName)) {
        //输出文件缓存
        echo Yii::$app->cache->get($cacheName);
    }else{
        //第一次没有缓存 输出原html
        //输出ob
        echo $html;
        //如果没有缓存 开始缓存
    Yii::$app->cache->set($cacheName,$html,3600*5);
    }


    ?>

</div>