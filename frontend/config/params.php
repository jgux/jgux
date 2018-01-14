<?php
return [
    'adminEmail' => 'admin@example.com',
    'sex'=>[
        1=>"男",
        2=>"女"
    ],
    //配送方式
    'delivers'=>[
        [
            'delivery_id'=>1,
            'delivery_name'=>'顺丰',
            'delivery_price'=>10.00,
            'info'=>'非常快',
        ],[
            'delivery_id'=>2,
            'delivery_name'=>'菜鸟',
            'delivery_price'=>40.00,
            'info'=>'有点慢',
        ],
    ],
    //支付方式
    'payType'=>[
        [
            'pay_type_id'=>1,
            'pay_type_name'=>'支付宝',
            'info'=>'支付宝，最安全快捷的支付'
        ],
        [
            'pay_type_id'=>2,
            'pay_type_name'=>'微信',
            'info'=>'微信支付，支持绝大数银行借记卡及部分银行信用卡'
        ],
        [
            'pay_type_id'=>3,
            'pay_type_name'=>'货到付款',
            'info'=>'货到付款，先验货再签收'
        ],


    ]  ,

    'easyWechat'=> [
        'debug'  => true,

        /**
         * 账号基本信息，请从微信公众平台/开放平台获取
         */
        'app_id'  => 'wx85adc8c943b8a477',         // AppID
        'secret'  => 'a687728a72a825812d34f307b630097b',     // AppSecret
        //'token'   => 'your-token',          // Token
        //'aes_key' => '',                    // EncodingAESKey，安全模式与兼容模式下请一定要填写！！！

        /**
         * 日志配置
         *
         * level: 日志级别, 可选为：
         *         debug/info/notice/warning/error/critical/alert/emergency
         * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        'log' => [
            'level'      => 'debug',
            'permission' => 0777,
            'file'       => '/tmp/easywechat.log',
        ],

        /**
         * OAuth 配置
         *
         * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
         * callback：OAuth授权完成后的回调页地址
         */
        /*'oauth' => [
            'scopes'   => ['snsapi_userinfo'],
            'callback' => '/examples/oauth_callback.php',
        ],*/

        /**
         * 微信支付
         */
        'payment' => [
            'merchant_id'        => '1228531002',//商户账号
            'key'                => 'a687728a72a825812d34f307b630097b',//密钥
            'notify_url'         => '默认的订单回调地址',//回调地址 客户支付成功微信服务器通知你的地址
            //'cert_path'  => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！需要认证证书
            //'key_path'     => 'path/to/your/key',      // XXX: 绝对路径！！！！ 需要认证证书
            // 'device_info'     => '013467007045764',
            // 'sub_app_id'      => '',
            // 'sub_merchant_id' => '',
            // ...
        ],

        /**
         * Guzzle 全局设置
         *
         * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
         */
        'guzzle' => [
            'timeout' => 3.0, // 超时时间（秒）
            'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）//我们自己的是http 没有带S
        ],
    ],


];
