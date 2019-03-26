<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\Period;
use App\Models\Product;
use App\Models\Withdraw;
use App\User;
use Encore\Admin\Widgets\InfoBox;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('管理中心');
            // $content->description('Description...');
            //$content->row(Dashboard::title());

            $content->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $start = date('Y-m-d', time()) . ' 00:00:00';
                    $end = date('Y-m-d', time()) . ' 23:59:59';
                    $infoBox1 = new InfoBox('今日真实会员总数', 'user', 'aqua',
                        '/admin/users?is_real=1&created_at[start]=' . $start . '&created_at[end]=' . $end,
                        User::counts(1));
                    $column->append($infoBox1);
                });

                $row->column(4, function (Column $column) {
                    $start = date('Y-m-d', time()) . ' 00:00:00';
                    $end = date('Y-m-d', time()) . ' 23:59:59';
                    $infoBox3 = new InfoBox('今日商品数量', 'eye', 'blue', '/admin/product?created_at[start]=' .
                        $start . '&created_at[end]=' . $end, Product::counts(1));
                    $column->append($infoBox3);
                });

                $row->column(4, function (Column $column) {
                    $start = date('Y-m-d', time()) . ' 00:00:00';
                    $end = date('Y-m-d', time()) . ' 23:59:59';
                    $infoBox2 = new InfoBox('今日订单总数', 'shopping-cart', 'purple', '/admin/order?created_at[start]=' .
                        $start . '&created_at[end]=' . $end, Order::counts(1));
                    $column->append($infoBox2);
                });
            });

            $content->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $infoBox1 = new InfoBox('真实会员总数', 'users', 'green', '/admin/users?is_real=1', User::counts());
                    $column->append($infoBox1);
                });

                $row->column(4, function (Column $column) {
                    $infoBox2 = new InfoBox('商品总数量', 'th-large', 'yellow', '/admin/product', Product::counts());
                    $column->append($infoBox2);
                });

                $row->column(4, function (Column $column) {
                    $infoBox3 = new InfoBox('待处理订单', 'file-text-o', 'red', '/admin/order', Order::counts());
                    $column->append($infoBox3);
                });

            });


            $content->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $infoBox1 = new InfoBox('平台总拍币数量', 'money', 'aqua',
                        '/admin/users?is_real=1',
                        User::all()->sum('bid_currency')
                    );
                    $column->append($infoBox1);
                });

                $row->column(4, function (Column $column) {

                    $infoBox3 = new InfoBox('平台总购物币数量', 'money', 'blue', '/admin/users?is_real=1',
                        User::all()->sum('shopping_currency')
                    );
                    $column->append($infoBox3);
                });

                $row->column(4, function (Column $column) {
                    $infoBox2 = new InfoBox('平台会员推广可提金额', 'money', 'purple', '/admin/users?is_real=1',
                        User::all()->sum('invite_currency')
                    );
                    $column->append($infoBox2);
                });
            });

            $content->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $infoBox1 = new InfoBox('平台已经提现总额', 'money', 'green', '/admin/users?is_real=1',
                        Withdraw::where(['status' => Withdraw::STATUS_COMPLETED])->sum('amount')
                    );
                    $column->append($infoBox1);
                });

                $row->column(4, function (Column $column) {
                    $infoBox2 = new InfoBox('充值总额/独立用户', 'money', 'yellow', '/admin/order',
                        Order::where('status',Order::STATUS_PAYED)->sum('pay_amount')
						.'/'.
						Order::where('status',Order::STATUS_PAYED)->distinct('buyer_id')->count('buyer_id')
                    );
                    $column->append($infoBox2);
                });

                $row->column(4, function (Column $column) {
                    $start = date('Y-m-d', time()) . ' 00:00:00';
                    $infoBox2 = new InfoBox('今日充值/独立用户', 'money', 'yellow', '/admin/order',
                        Order::where('status',Order::STATUS_PAYED)->where('created_at','>',$start)->sum('pay_amount')
						.'/'.
						Order::where('status',Order::STATUS_PAYED)->where('created_at','>',$start)->distinct('buyer_id')->count('buyer_id')
                    );
                    $column->append($infoBox2);
                });
                /*
                $row->column(4, function (Column $column) {
                    $infoBox2 = new InfoBox('平台拍卖流水总额(真实会员)', 'money', 'yellow', '/admin/order',
                        Order::where('status', '<>', Order::STATUS_WAIT_PAY)->sum('pay_amount')
                    );
                    $column->append($infoBox2);
                });
                $row->column(4, function (Column $column) {
                    $infoBox2 = new InfoBox('平台拍卖流水总额(含虚拟会员)', 'money', 'red    ', '/admin/period',
                        number_format(Period::where(['real_bid' => User::TYPE_ROBOT])->sum('bid_price') * 10
                            + Order::where('status', '<>', Order::STATUS_WAIT_PAY)->sum('pay_amount'), 2)
                    );
                    $column->append($infoBox2);
                });
                */
            });

//            $content->row(function (Row $row) {
//                $row->column(6, function (Column $column) {
//                    $column->append(Dashboard::dependencies());
//                });
//                $row->column(6, function (Column $column) {
//
//                    $column->append(Dashboard::environment());
//                });
//
//            });

        });
    }
}
