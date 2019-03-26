<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCouponList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE TABLE `coupon_list` (
              `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '表id',
              `cid` int(8) NOT NULL DEFAULT '0' COMMENT '优惠券 对应coupon表id',
              `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发放类型 1 按订单发放 2 注册 3 邀请 4 按用户发放',
              `uid` int(8) NOT NULL DEFAULT '0' COMMENT '用户id',
              `order_id` int(8) NOT NULL DEFAULT '0' COMMENT '订单id',
              `get_order_id` int(11) DEFAULT '0' COMMENT '优惠券来自订单ID',
              `use_time` int(11) NOT NULL DEFAULT '0' COMMENT '使用时间',
              `code` varchar(10) DEFAULT '' COMMENT '优惠券兑换码',
              `send_time` int(11) NOT NULL DEFAULT '0' COMMENT '发放时间',
              `status` tinyint(1) DEFAULT '0' COMMENT '0未使用1已使用2已过期',
              `created_at` TIMESTAMP NULL  COMMENT '创建时间',
              `updated_at` TIMESTAMP NULL  COMMENT '修改时间',
              PRIMARY KEY (`id`),
              KEY `cid` (`cid`),
              KEY `uid` (`uid`),
              KEY `code` (`code`),
              KEY `order_id` (`order_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
