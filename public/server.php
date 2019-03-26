<?php
use Illuminate\Container\Container;

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */
/*
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';*/

echo config('params.wei_xin_app_id');
exit;
include __DIR__ . '/vendor/autoload.php'; // 引入 composer 入口文件
use EasyWeChat\Foundation\Application;

$options = [
    'debug' => true,
    'app_id' => $this->wei_xin_app_id,
    'secret' => 'you-secret',
    'token' => 'easywechat',
    // 'aes_key' => null, // 可选
    'log' => [
        'level' => 'debug',
        'file' => 'C:\xampp\htdocs\easywechat.log', // XXX: 绝对路径！！！！
    ],
    //...
];


$app = new Application($options);

$app->server->setMessageHandler(function ($message) {
    return "您好！欢迎关注我!";
});

$response = $app->server->serve();
// 将响应输出
//$response->send(); // Laravel 里请使用：return $response;
return $response;