<?php

namespace App;

class Coupon extends Base
{
    protected $table = 'coupon';

    const TYPE_SCOPE_ALL = 0; //全店通用
    const TYPE_SCOPE_APPOINT_PRODUCT = 1; //指定商品可用
    const TYPE_SCOPE_APPOINT_PRODUCT_TYPE = 2; //指定的商品类型

    public static $scope = [
        self::TYPE_SCOPE_ALL => '全店通用',
        self::TYPE_SCOPE_APPOINT_PRODUCT => '指定商品可用',
        self::TYPE_SCOPE_APPOINT_PRODUCT_TYPE => '指定的商品类型',
    ];

}
