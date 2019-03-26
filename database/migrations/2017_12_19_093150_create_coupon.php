<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP TABLE IF EXISTS `tp_coupon`;");
        DB::statement(
            "CREATE TABLE `coupon` (
              `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '表id',
              `name` varchar(50) NOT NULL DEFAULT '' COMMENT '优惠券名字',
              `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发放类型 0下单赠送1 指定发放 2 免费领取 3线下发放',
              `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券金额',
              `condition` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用条件',
              `createnum` int(11) DEFAULT '0' COMMENT '发放数量',
              `send_num` int(11) DEFAULT '0' COMMENT '已领取数量',
              `use_num` int(11) DEFAULT '0' COMMENT '已使用数量',
              `send_start_time` TIMESTAMP NULL  COMMENT '发放开始时间',
              `send_end_time` TIMESTAMP NULL  COMMENT '发放结束时间',
              `use_start_time` TIMESTAMP NULL COMMENT '使用开始时间',
              `use_end_time` TIMESTAMP NULL  COMMENT '使用结束时间',
              `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
              `status` int(2) DEFAULT NULL COMMENT '状态：0无效，1有效',
              `use_type` tinyint(1) DEFAULT '0' COMMENT '使用范围：0全店通用1指定商品可用2指定分类商品可用',
              `created_at` TIMESTAMP NULL  COMMENT '创建时间',
              `updated_at` TIMESTAMP NULL  COMMENT '修改时间',
              PRIMARY KEY (`id`),
              KEY `use_end_time` (`use_end_time`)
            ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;");
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
