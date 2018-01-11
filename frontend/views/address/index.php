<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>收货地址</title>
    <link rel="stylesheet" href="/regist/style/base.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/global.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/header.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/home.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/address.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/bottomnav.css" type="text/css">
    <link rel="stylesheet" href="/regist/style/footer.css" type="text/css">

    <script type="text/javascript" src="/regist/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/regist/js/header.js"></script>
    <script type="text/javascript" src="/regist/js/home.js"></script>
    <script type="text/javascript" src="/regist/js/PCASClass.js"></script>

</head>
<body>
<!-- 顶部导航 start -->
<?php
//var_dump(Yii::getAlias("@app"));exit;
include_once Yii::getAlias("@app/views/common/header.php");?>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 头部 start -->
<?php include_once Yii::getAlias("@app/views/common/nav.php")?>
<!-- 头部 end-->

<div style="clear:both;"></div>

<!-- 页面主体 start -->
<div class="main w1210 bc mt10">
    <div class="crumb w1210">
        <h2><strong>我的XX </strong><span>> 我的订单</span></h2>
    </div>

    <!-- 左侧导航菜单 start -->
    <div class="menu fl">
        <h3>我的XX</h3>
        <div class="menu_wrap">
            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">我的订单</a></dd>
                <dd><b>.</b><a href="">我的关注</a></dd>
                <dd><b>.</b><a href="">浏览历史</a></dd>
                <dd><b>.</b><a href="">我的团购</a></dd>
            </dl>

            <dl>
                <dt>账户中心 <b></b></dt>
                <dd class="cur"><b>.</b><a href="">账户信息</a></dd>
                <dd><b>.</b><a href="">账户余额</a></dd>
                <dd><b>.</b><a href="">消费记录</a></dd>
                <dd><b>.</b><a href="">我的积分</a></dd>
                <dd><b>.</b><a href="">收货地址</a></dd>
            </dl>

            <dl>
                <dt>订单中心 <b></b></dt>
                <dd><b>.</b><a href="">返修/退换货</a></dd>
                <dd><b>.</b><a href="">取消订单记录</a></dd>
                <dd><b>.</b><a href="">我的投诉</a></dd>
            </dl>
        </div>
    </div>
    <!-- 左侧导航菜单 end -->

    <!-- 右侧内容区域 start -->
    <div class="content fl ml10">
        <div class="address_hd">
            <h3>收货地址薄</h3>
            <dl>
                <dt>1.许坤 北京市 昌平区 仙人跳区 仙人跳大街 17002810530 </dt>
                <dd>
                    <a href="">修改</a>
                    <a href="">删除</a>
                    <a href="">设为默认地址</a>
                </dd>
            </dl>
            <dl class="last"> <!-- 最后一个dl 加类last -->
                <dt>2.许坤 四川省 成都市 高新区 仙人跳大街 17002810530 </dt>
                <dd>
                    <a href="">修改</a>
                    <a href="">删除</a>
                    <a href="">设为默认地址</a>
                </dd>
            </dl>

        </div>

        <div class="address_bd mt10">
            <h4>新增收货地址</h4>
            <form action="<?php \yii\helpers\Url::to(["index"])?>" name="address_form" method="post">
                <ul>
                    <li>
                        <label for=""><span>*</span>收 货 人：</label>
                        <input type="text" name="username" class="txt" />
                    </li>
                    <li>
                        <label for=""><span>*</span>所在地区：</label>
                        <select name="province3"></select>
                        <select name="city3"></select>
                        <select name="area3"></select>
                    </li>


                    <li>
                        <label for=""><span>*</span>详细地址：</label>
                        <input type="text" name="detailed" class="txt address"  />
                    </li>
                    <li>
                        <label for=""><span>*</span>手机号码：</label>
                        <input type="text" name="phone" class="txt" />
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="checkbox" name="" class="check" />设为默认地址
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="submit" name="" class="btn" value="保存" />
                    </li>
                </ul>
            </form>
        </div>

    </div>
    <!-- 右侧内容区域 end -->
</div>
<!-- 页面主体 end-->

<div style="clear:both;"></div>

<!-- 底部导航 start -->
<div class="bottomnav w1210 bc mt10">
    <div class="bnav1">
        <h3><b></b> <em>购物指南</em></h3>
        <ul>
            <li><a href="">购物流程</a></li>
            <li><a href="">会员介绍</a></li>
            <li><a href="">团购/机票/充值/点卡</a></li>
            <li><a href="">常见问题</a></li>
            <li><a href="">大家电</a></li>
            <li><a href="">联系客服</a></li>
        </ul>
    </div>

    <div class="bnav2">
        <h3><b></b> <em>配送方式</em></h3>
        <ul>
            <li><a href="">上门自提</a></li>
            <li><a href="">快速运输</a></li>
            <li><a href="">特快专递（EMS）</a></li>
            <li><a href="">如何送礼</a></li>
            <li><a href="">海外购物</a></li>
        </ul>
    </div>


    <div class="bnav3">
        <h3><b></b> <em>支付方式</em></h3>
        <ul>
            <li><a href="">货到付款</a></li>
            <li><a href="">在线支付</a></li>
            <li><a href="">分期付款</a></li>
            <li><a href="">邮局汇款</a></li>
            <li><a href="">公司转账</a></li>
        </ul>
    </div>

    <div class="bnav4">
        <h3><b></b> <em>售后服务</em></h3>
        <ul>
            <li><a href="">退换货政策</a></li>
            <li><a href="">退换货流程</a></li>
            <li><a href="">价格保护</a></li>
            <li><a href="">退款说明</a></li>
            <li><a href="">返修/退换货</a></li>
            <li><a href="">退款申请</a></li>
        </ul>
    </div>

    <div class="bnav5">
        <h3><b></b> <em>特色服务</em></h3>
        <ul>
            <li><a href="">夺宝岛</a></li>
            <li><a href="">DIY装机</a></li>
            <li><a href="">延保服务</a></li>
            <li><a href="">家电下乡</a></li>
            <li><a href="">京东礼品卡</a></li>
            <li><a href="">能效补贴</a></li>
        </ul>
    </div>
</div>
<!-- 底部导航 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt10">
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
<script  language="javascript" defer>
    new PCAS("province3","city3","area3");

    function StringBuffer(str) {
        var arr = [];
        str = str || "";
        var size = 0; // 存放数组大小
        arr.push(str);
        // 追加字符串
        this.append = function(str1) {
            arr.push(str1);
            return this;
        };
        // 返回字符串
        this.toString = function() {
            return arr.join("");
        };
        // 清空
        this.clear = function(key) {
            size = 0;
            arr = [];
        };
        // 返回数组大小
        this.size = function() {
            return size;
        };
        // 返回数组
        this.toArray = function() {
            return buffer;
        };
        // 倒序返回字符串
        this.doReverse = function() {
            var str = buffer.join('');
            str = str.split('');
            return str.reverse().join('');
        };
    }


</script>
</body>
</html>

