<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Facades\DB;

class Income extends Common
{
    protected $table = 'income';
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'user_id',
        'amount',
        'return_proportion', //返还比例
        'used_amount', //使用的金额
        'name',
        'voucher_id',
        'product_id',
        'expired_at',
        'period_id',
        'order_id',
    ];

    const STATUS_ALREADY_WITHDRAW = 0; //已提现

    /** 结算所有未竞拍用户的返回拍币金额 */
    public static function settlement($periodId, $userId)
    {
        $bids = DB::table('bid')
            ->select(DB::raw('product_id,pay_amount,count(id) as counts, user_id'))
            ->where([
                'period_id' => $periodId,
                'status' => Bid::STATUS_FAIL,
                'pay_type' => self::TYPE_BID_CURRENCY, //只转换拍币
                'is_real' => User::TYPE_REAL_PERSON
            ])->where('user_id', '<>', $userId)//竞拍成功者没有返回购物币
            ->groupBy(['user_id', 'pay_amount', 'product_id'])
            ->get();
        $vouchers = new  Vouchers();
        foreach ($bids as $bid) {
            $data = [
                'user_id' => $bid->user_id,
                'type' => self::TYPE_SHOPPING_CURRENCY,
                'amount' => $bid->pay_amount * $bid->counts * config('bid.return_proportion'),
                'return_proportion' => config('bid.return_proportion'),
                'used_amount' => $bid->pay_amount * $bid->counts,
                'name' => '订单拍币返还',
                'expired_at' => config('bid.bid_currency_expired_at'),
                'product_id' => $bid->product_id,
                'period_id' => $periodId
            ];
            list($amount, $count) = self::getAmountSum($bid->user_id, $bid->product_id);
            $vou = [
                'product_id' => $bid->product_id,
                'status' => Vouchers::STATUS_ENABLE,
                'user_id' => $bid->user_id,
                'expired_at' => config('bid.bid_currency_expired_at'),
                'content' => '',
                'amount' => $amount + $data['amount'],
                'count' => $count,
            ];
            $res = $vouchers->saveData($vou);
            $data['voucher_id'] = $res;
            self::create($data);//保存记录
            DB::table('users')->where(['id' => $bid->user_id])->increment('shopping_currency', $data['amount']);
        }
    }

    /** 获取可用的购物币总和 */
    public static function getAmountSum($userId, $productId)
    {
        $query = Income::where([
            'type' => self::TYPE_SHOPPING_CURRENCY,
            'user_id' => $userId,
            'product_id' => $productId,
            'status' => self::STATUS_ENABLE,
        ])->where('expired_at', '>', date('Y-m-d H:i:s'));
        return [$query->sum('amount'), $query->count('id')];
    }

    /** 自动竞拍成功，返回剩余拍币 */
    public function autoSettlement($data, $userId)
    {
        self::create($data);//保存记录
        if ($data['type'] == self::TYPE_GIFT_CURRENCY) {
            DB::table('users')->where(['id' => $userId])->increment('gift_currency', $data['amount']);
        } elseif ($data['type'] == self::TYPE_BID_CURRENCY) {
            DB::table('users')->where(['id' => $userId])->increment('bid_currency', $data['amount']);
        }
    }

    /** 收入明细 */
    public function detail($userId, $type = [])
    {
        $incomes = Income::where([
                'user_id' => $userId
            ] + $type)->offset($this->offset)->limit($this->limit)->orderBy('created_at', 'desc')->get();
        $data = [];
        foreach ($incomes as $income) {
            $data[] = [
                'title' => $income->name,
                'created_at' => $income->created_at,
                'amount' => '+' . round($income->amount) . $this->getCurrencyStr($income->type),
            ];
        }
        if (empty($data) && $this->offset == 0) {
            self::showMsg('没有数据', 2);
        }
        return $data;
    }

    /** 用户充值 */
    public function recharge($data)
    {
        return self::create($data);
    }

    /** 查看是否有返还的购物币 */
    public function shoppingCurrency($userId, $getOne = false)
    {
        //查询可用的购物币
        if ($getOne) {
            $income = Income::where([
                'type' => self::TYPE_SHOPPING_CURRENCY,
                'status' => self::STATUS_ENABLE,
                'user_id' => $userId
            ])->first();
            return count($income) > 0 ? 1 : 0;
        } else {
            $usable = $disable = [];
            $vouchers = Vouchers::where([
                'user_id' => $userId,
            ])->get();
            $products = new Product();

            foreach ($vouchers as $voucher) {
                $expired_at = strtotime($voucher->expired_at) - time();
                $product = $products->getCacheProduct($voucher->product_id);
                if ($voucher->status == Vouchers::STATUS_ENABLE && $expired_at > 0) {
                    $usableDetail = [];
                    $usableIncome = Income::where([
                        'user_id' => $userId,
                        'voucher_id' => $voucher->id,
                        'status' => Income::STATUS_ENABLE
                    ])->where('expired_at', '>', date('Y-m-d H:i:s'))->select('created_at', 'expired_at', 'amount')->get();
                    foreach ($usableIncome as $item) {
                        $usableDetail[] = [
                            'id' => $voucher->id,
                            'title' => $product->title,
                            'img' => env('QINIU_URL_IMAGES') . $product->img_cover,
                            'created_at' => $item->created_at,
                            'expired_at' => round((strtotime($item->expired_at) - time()) / 86400) . '天后过期',
                            'amount' => round($item->amount)
                        ];
                    }
                    $usable[] = [
                        'id' => $voucher->id,
                        'product_id' => $product->id,
                        'title' => $product->title,
                        'img' => env('QINIU_URL_IMAGES') . $product->img_cover,
                        'created_at' => $voucher->created_at,
                        'expired_at' => round($expired_at / 86400) . '天后过期',
                        'count' => count($usableDetail),
                        'amount' => round($voucher->amount),
                        'detail' => $usableDetail
                    ];
                } elseif ($voucher->status == Vouchers::STATUS_ALREADY_USED) {
                    $disable = [];
                    $disableDetail = [];
                    $disableIncome = Income::where([
                        'user_id' => $userId,
                        'voucher_id' => $voucher->id,
                    ])->get();
                    foreach ($disableIncome as $item) {
                        $disableDetail[] = [
                            'id' => $voucher->id,
                            'title' => $product->title,
                            'img' => env('QINIU_URL_IMAGES') . $product->img_cover,
                            'created_at' => $item->created_at,
                            'expired_at' => $item->expired_at,
                            'amount' => round($item->amount),
                            'type' => 2 //表示已使用
                        ];
                    }
                    $disable[] = [
                        'id' => $voucher->id,
                        'product_id' => $product->id,
                        'title' => $product->title,
                        'img' => env('QINIU_URL_IMAGES') . $product->img_cover,
                        'created_at' => $voucher->created_at,
                        'expired_at' => round($expired_at / 86400) . '天后过期',
                        'count' => count($disableDetail),
                        'amount' => round($voucher->amount),
                        'detail' => $disableDetail,
                        'type' => 2
                    ];
                } else {
                    $disable = [];
                    $disableDetail = [];
                    $disableIncome = Income::where([
                        'user_id' => $userId,
                        'voucher_id' => $voucher->id,
                    ])->where('expired_at', '<', date('Y-m-d H:i:s'))->select('created_at', 'expired_at', 'amount')->get();
                    foreach ($disableIncome as $item) {
                        $disableDetail[] = [
                            'id' => $voucher->id,
                            'title' => $product->title,
                            'img' => env('QINIU_URL_IMAGES') . $product->img_cover,
                            'created_at' => $item->created_at,
                            'expired_at' => $item->expired_at,
                            'amount' => round($item->amount),
                            'type' => 3
                        ];
                    }

                    $disable[] = [
                        'id' => $voucher->id,
                        'product_id' => $product->id,
                        'title' => $product->title,
                        'img' => env('QINIU_URL_IMAGES') . $product->img_cover,
                        'created_at' => $voucher->created_at,
                        'expired_at' => $voucher->expired_at,
                        'count' => count($disableDetail),
                        'amount' => round($voucher->amount),
                        'type' => 3, //表示已过期
                        'detail' => $disableDetail
                    ];
                }
            }
            $data = [
                'shopping_rule' => [
                    'id' => 8,
                    'title' => '使用规则',
                    'img' => '',
                    'function' => 'html',
                    'params' => [
                        'key' => 'url',
                        'type' => 'String',
                        'value' => 'https://' . $_SERVER["HTTP_HOST"] . '/api/shopping-rule',
                    ],
                ],
                'usable' => $usable,
                'disable' => $disable
            ];
            return $data;
        }
    }

    /** 可提现金额 */
    public function withdrawAmount($userId)
    {
        return DB::table('income')->where([
            'user_id' => $userId,
            'type' => self::TYPE_INVITE_CURRENCY,
        ])->where('status', '<>', self::STATUS_ALREADY_WITHDRAW)
            ->sum('amount');
    }

    /** 我的绩效 */
    public function performance($userId, $canWithdraw)
    {
        $incomes = self::where([
            'user_id' => $userId,
            'type' => self::TYPE_INVITE_CURRENCY
        ])->offset($this->offset)->limit($this->limit)->get();
        $withdraws = $alreadyWithdraw = $data = [];
        foreach ($incomes as $income) {
            $withdraws[] = $income->amount;
            $data[] = [
                'title' => $income->name,
                'created_at' => $income->created_at,
                'amount' => $income->amount
            ];
        }
        $withdraw = array_sum($withdraws);
        $alWithdraw = ($withdraw - $canWithdraw) >= 0 ? ($withdraw - $canWithdraw) : 0;
        $res = [
            'total_amount' => number_format($withdraw, 2),
            'withdraw' => $canWithdraw,
            'already_withdraw' => number_format($alWithdraw, 2),
            'income' => $data
        ];
        return $res;
    }
}