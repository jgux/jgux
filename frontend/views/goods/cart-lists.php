
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>购物车页面</title>
    <link rel="stylesheet" href="/regist/style/base.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/global.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/header.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/cart.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/footer.css" type="text/css">

    <script type="text/javascript" src="/regist/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/regist/js/cart1.js"></script>

</head>
<body>
<!-- 顶部导航 start -->
<?php
//var_dump(Yii::getAlias("@app"));exit;
include_once Yii::getAlias("@app/views/common/header.php");?>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/regist/images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr">
            <ul>
                <li class="cur">1.我的购物车</li>
                <li>2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="mycart w990 mt10 bc">
    <h2><span>我的购物车</span></h2>
    <table>
        <thead>
        <tr>
            <th class="col1">商品名称</th>
            <th class="col3">单价</th>
            <th class="col4">数量</th>
            <th class="col5">小计</th>
            <th class="col6">操作</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($goods as $good): ?>
        <tr id="<?=$good['id']?>">
            <td class="col1"><a href=""><img src="<?=$good['logo']?>" alt="" /></a> <strong><a href=""><?=$good['name']?></a></strong></td>
            <td class="col3">￥<span><?=$good['shop_price']?></span></td>
            <td class="col4">
                <a href="javascript:;" class="reduce_num"></a>
                <input type="text" name="amount" value="<?=$good['num']?>" class="amount"/>
                <a href="javascript:;" class="add_num"></a>
            </td>
            <td class="col5">￥<span><?=$good['num']*$good['shop_price']?></span></td>
            <td class="col6"><a href="<?=\yii\helpers\Url::to(['goods/del-cart','id'=>$good['id']]) ?>">删除</a></td>
        </tr>
        <?php endforeach; ?>


        </tbody>
        <tfoot>
        <tr>
            <td colspan="6">购物金额总计： <strong>￥ <span id="total">1870.00</span></strong></td>
        </tr>
        </tfoot>
    </table>
    <div class="cart_btn w990 bc mt10">
        <a href="" class="continue">继续购物</a>
        <a href="<?= Yii::$app->user->isGuest?\yii\helpers\Url::to(["user/login"]):\yii\helpers\Url::to(["goods/cart-address"]);
        ?>" class="checkout">结 算</a>
    </div>
</div>
<!-- 主体部分 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/regist/images/xin.png" alt="" /></a>
        <a href=""><img src="/regist/images/kexin.jpg" alt="" /></a>
        <a href=""><img src="/regist/images/police.jpg" alt="" /></a>
        <a href=""><img src="/regist/images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->
</body>
</html>
