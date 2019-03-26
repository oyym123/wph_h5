<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/7/25
 * Time: 16:24
 */
date_default_timezone_set('PRC');
return [
    'wx_app_id' => 'wxb44c2f38e9fb041b',
    'wx_mch_id' => '1509936521',
    'robot_rate' => mt_rand(5, 15) / 100, //随机概率（即没有真人参与时，中标价不超过售价的4%~20%）
    'init_countdown' => 60, //初始化竞拍时间5分钟
    'return_proportion' => 1, //购物币返还比例
    'user_gift_currency' => 5, //新用户赠币数量
    'order_expired_at' => date('Y-m-d H:i:s', time() + 86400 * 1000), //订单过期时间
    'bid_currency_expired_at' => date('Y-m-d H:i:s', time() + 86400 * 30), //返还的购物币过期时间
    'divide_proportion_level_1' => 0.15, //一级邀请人分成比 5%
    'divide_proportion_level_2' => 0.35, //二级邀请人分成比 3%
];