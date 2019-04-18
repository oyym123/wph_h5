<?php

return [
    'alipay' => [
        // 支付宝分配的 APPID
        'app_id' => env('ALI_APP_ID', ''),

        // 支付宝异步通知地址
        'notify_url' => '',

        // 支付成功后同步通知地址
        'return_url' => '',

        // 阿里公共密钥，验证签名时使用
        'ali_public_key' => env('ALI_PUBLIC_KEY', ''),

        // 自己的私钥，签名时使用
        'private_key' => env('ALI_PRIVATE_KEY', ''),

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/alipay.log'),
            //  'level' => 'debug'
            //  'type' => 'single', // optional, 可选 daily.
            //  'max_file' => 30,
        ],

        // optional，设置此参数，将进入沙箱模式
        // 'mode' => 'dev',
    ],

    'wechat' => [
        // 公众号 APPID
        'app_id' => env('WECHAT_APPID', ''),

        // 小程序 APPID
        'miniapp_id' => env('WECHAT_APPID', ''),

        // APP 引用的 appid
        'appid' => env('WECHAT_APPID', 'wxb44c2f38e9fb041b'),

        // 微信支付分配的微信商户号
        'mch_id' => env('WECHAT_MCH_ID', '1509936521'),

        // 微信支付异步通知地址
    //    'notify_url' => $_SERVER["HTTP_HOST"] . '/api/wx-notify/notify',

        // 微信支付签名秘钥
        'key' => env('WECHAT_KEY', '3173259eA0d5E5d12e3a9b2c90N0Qdb0'),

        // 客户端证书路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_client' => '',

        // 客户端秘钥路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_key' => '',

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/wechat.log'),
            'level' => 'debug',
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30,
        ],
        'http' => [
            'timeout' =>5.0,
            'connect_timeout'=>5.0
        ],
        // optional
        // 'dev' 时为沙箱模式
        // 'hk' 时为东南亚节点
        'mode' => 'normal',
    ],
];
