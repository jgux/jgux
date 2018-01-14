<?php
/**
 * @var $controller \frontend\controllers\AddressController
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>填写核对订单信息</title>
    <link rel="stylesheet" href="/regist/style/base.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/global.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/header.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/fillin.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/footer.css" type="text/css">

    <script type="text/javascript" src="/regist/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/regist/js/PCASClass.js" ></script>


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
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<form action="/order/index" method="post" id="order">
<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息 </h3>
            <div class="address_select">
                <ul>
                    <?php foreach ($address as $k1=>$v1): ?>
                    <li class="cur">
                        <input type="radio" name="address_id" <?=$v1['status']?'checked':''?> value="<?=$v1['id']?>"/>
                        <?=$v1['username']." ".$v1['province']." ".$v1['city']." ".$v1['area']." ".$v1['detailed']." ".$v1['phone'] ?>
                        <a href="">设为默认地址</a>
                        <a href="">编辑</a>
                        <a href="">删除</a>
                    </li>
                    <?php endforeach; ?>
            </div>
        </div>
        <!-- 收货人信息  end-->


        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式</h3>
            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (Yii::$app->params['delivers'] as $k1=>$v1): ?>
                    <tr class="<?=$k1==0?'cur':''?>">

                        <td>
                            <input type="radio" name="delivery_id" <?=$k1==0?'checked':''?>
                            delivery_price="<?=$v1['delivery_price']?>" value="<?=$v1['delivery_id']?>"
                            />
                            <?=$v1['delivery_name']?>
                        </td>
                        <td>￥<?=$v1['delivery_price']?></td>
                        <td><?=$v1['info']?></td>
                        <?php endforeach; ?>
                    </tr>

                    </tbody>
                </table>
<!--                <a href="" class="confirm_btn"><span>确认送货方式</span></a>-->
            </div>
        </div>
        <!-- 配送方式 end -->


        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式</h3>
            <div class="pay_select">
                <table>
                    <?php foreach (Yii::$app->params['payType'] as $k1=>$v1): ?>
                    <tr class="<?=$k1==0?'cur':''?>">
                        <td class="col1"><input type="radio" name="pay_type_id" value="<?=$v1['pay_type_id']?>" <?=$k1==0?'checked':''?>/><?=$v1['pay_type_name']?></td>
                        <td class="col2"><?=$v1['info']?></td>
                    </tr>
                    <?php endforeach;?>
                </table>
<!--                <a href="" class="confirm_btn"><span>确认支付方式</span></a>-->
            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>

                <?php
                //var_dump($goods);
                foreach ($goods as $good): ?>
                    <tr>
                        <td class="col1"><a href=""><img src="<?=$good['logo']?>" alt="" /></a>  <strong><a href=""><?=$good['name']?></a></strong></td>
                        <td class="col3"><?=$good['shop_price']?></td>
                        <td class="col4"><?=$good['num']?></td>
                        <td class="col5"><span><?=$good['num']*$good['shop_price']?></span></td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?=count($goods)?> 件商品，总商品金额：</span>
                                <?php $goods=\yii\helpers\ArrayHelper::map($goods,'shop_price','num') ;
                                $price="";
                                foreach ($goods as $k=>$v){
                                    $price+=$k*$v;
                                }


                                ?>
                                <em id="money">￥<?=$price?></em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em id="pay_price">￥<?=Yii::$app->params['delivers'][0]['delivery_price']?></em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em class="total_money">￥<?=$price +Yii::$app->params['delivers'][0]['delivery_price']?></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <a href="javascript:void (0)" onclick="submit()"><span>提交订单</span></a>
<!--        <input type="submit" value="提交">-->
        <p>应付总额：<strong class="total_money">￥<?=$price?></strong></p>

    </div>
</div>
<!-- 主体部分 end -->
</form>

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
<script>

    function submit() {
        document.getElementById("order").submit();
    }

        $(function () {
           //修改运费
            $("[name='delivery']").change(function () {
                //console.dir($(this).attr('delivery_price'))
                var price=$(this).attr('delivery_price') -0; //转化为数据类型
                $("#pay_price").text('￥'+price);//给运费赋值
                //替换总价
                $(".total_money").text('￥'+ ($("#money").text().substring(1) -0 +price));
                //console.dir($("#money").text().substring(1));
            });
        });


</script>

<!-- 底部版权 end -->
</body>
</html>
