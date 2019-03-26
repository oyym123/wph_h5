<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expend extends Common
{
    protected $table = 'expend';
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'user_id',
        'amount',
        'pay_amount',
        'name',
        'product_id',
        'period_id',
    ];

    /** 竞拍支出 */
    public function bidPay($data)
    {
        self::create($data);
    }

    /** 用户每一期支付的费用 */
    public function periodExpend($period, $userId)
    {
        $expends = Expend::where([
            'period_id' => $period,
            'user_id' => $userId
        ])->get();
        if (count($expends) > 0) {
            $bidCurrency = $giftCurrency = [];
            foreach ($expends as $expend) {
                if ($expend->type == self::TYPE_BID_CURRENCY) {
                    $bidCurrency[] = $expend->amount;
                } else {
                    $giftCurrency[] = $expend->amount;
                }
            }
            $data = [
                'bid_currency' => array_sum($bidCurrency),
                'gift_currency' => array_sum($giftCurrency),
            ];
            return $data;
        } else {
            return [
                'bid_currency' => 0,
                'gift_currency' => 0,
            ];
        }
    }

    /** 支出明细 */
    public function detail($userId)
    {
        $expends = Expend::where([
            'user_id' => $userId
        ])->offset($this->offset)->limit($this->limit)->orderBy('created_at', 'desc')->get();
        $data = [];
        foreach ($expends as $expend) {
            $data[] = [
                'title' => $expend->name,
                'created_at' => $expend->created_at,
                'amount' => '-' . round($expend->amount) . $this->getCurrencyStr($expend->type),
            ];
        }
        if (empty($data) && $this->offset == 0) {
            self::showMsg('没有数据', 2);
        }
        return $data;
    }
}
