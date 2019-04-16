<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Facades\DB;

class AutoBid extends Common
{
    protected $table = 'auto_bid';
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'times',
        'status',
        'pay_amount',
        'amount_type',
        'period_id',
        'product_id',
        'remain_times', //剩余次数
    ];

    const STATUS_NOT_START = 10;     //未开始
    const STATUS_IN_PROGRESS = 20;   //进行中
    const STATUS_OVER = 30;          //已结束

    /** 提交自动竞拍信息 */
    public function submitInfo($request)
    {
        $period = Period::has('product')->where([
            'id' => $request->period_id,
            'status' => Period::STATUS_IN_PROGRESS
        ])->first();
        if (!$period) {
            list($info, $status) = $this->returnRes('', self::CODE_NO_DATA);
            self::showMsg($info, $status);
        }
        $autoBid = AutoBid::where([
            'period_id' => $request->period_id,
            'status' => AutoBid::STATUS_IN_PROGRESS,
            'user_id' => $this->userId
        ])->first();
        if ($autoBid) {
            self::showMsg('正在自动竞拍中,请勿重复提交！', self::CODE_ERROR);
        }

        if ($period) {
            $product = $period->product;
            $payAmount = $product->pay_amount * $request->times; //需要的金额
            //判断消耗的金额类型
            if ($this->userIdent->gift_currency >= $payAmount) {
                $type = self::TYPE_GIFT_CURRENCY;
                DB::table('users')->where(['id' => $this->userId])->decrement('gift_currency', $payAmount);
            } elseif ($this->userIdent->bid_currency >= $payAmount) {
                $type = self::TYPE_BID_CURRENCY;
                DB::table('users')->where(['id' => $this->userId])->decrement('bid_currency', $payAmount);
            } else {
                return [
                    'status' => 30, //余额不足，需要充值
                    'pay_amount' => $payAmount - $this->userIdent->bid_currency
                ];
            }

            $data = [
                'user_id' => $this->userId,
                'times' => $request->times,
                'status' => AutoBid::STATUS_IN_PROGRESS,
                'period_id' => $request->period_id,
                'pay_amount' => $product->pay_amount,
                'amount_type' => $type,
                'product_id' => $product->id,
                'remain_times' => $request->times,
            ];

            AutoBid::create($data);

            $expend = [
                'type' => $type,
                'user_id' => $this->userId,
                'amount' => $payAmount,
                'pay_amount' => $product->pay_amount,
                'name' => '竞拍助手设置锁定',
                'product_id' => $product->id,
                'period_id' => $request->period_id,
            ];
            (new Expend())->bidPay($expend);

            $expend = (new Expend())->periodExpend($period->id, $this->userId);
            $res = [
                'status' => 20, //提交自动竞拍信息成功
                'used_real_bids' => $expend['bid_currency'],
                'used_gift_bids' => $expend['gift_currency'],
                'used_money' => number_format($expend['bid_currency'], 2),
                'total_times' => $request->times
            ];
            return $res;
        }
    }

    /** 开始自动竞拍 */
    public function bid()
    {
        $autoBids = DB::table('auto_bid')->where([
            'status' => self::STATUS_IN_PROGRESS,
        ])->where('remain_times', '>', 0)->get();
        $bid = new Bid();
        $redis = app('redis')->connection('first');

        foreach ($autoBids as $item) {
            if ($bid->getLastBidInfo($redis, $item->period_id, 'user_id') != $item->user_id) { //当最后一个竞拍人的id不是自己的时候，才可以自动竞拍
                $bid->userIdent = User::find($item->user_id);
                $bid->userId = $item->user_id;
                $bid->amount_type = $item->amount_type;
                $res = $bid->personBid($item->period_id, 1, $item);
                if ($res['status'] == 10) { //竞拍失败，减少次数
                    if ($item->remain_times == 1) {//表示剩最后一次的时候，转换状态
                        DB::table('auto_bid')->where(['id' => $item->id])->update(['status' => self::STATUS_OVER]);
                    }
                    DB::table('auto_bid')->where(['id' => $item->id])->decrement('remain_times', 1);
                }
            }

        }
    }

    /** 返还竞拍币 */
    public function back($periodId, $userId)
    {
        $item = DB::table('auto_bid')->where([
            'user_id' => $userId,
            'period_id' => $periodId,
        ])->orderBy('created_at', 'desc')->first();

        if ($item && $item->remain_times > 0) {
            $data = [
                'user_id' => $userId,
                'type' => $item->amount_type,
                'amount' => $item->remain_times * $item->pay_amount,
                'return_proportion' => config('bid.return_proportion'),
                'used_amount' => $item->pay_amount * ($item->times - $item->remain_times),
                'name' => '自动竞拍剩余拍币返还',
                'product_id' => $item->product_id,
                'period_id' => $item->period_id
            ];

            (new Income())->autoSettlement($data, $item->user_id);

            DB::table('auto_bid')->where([
                'user_id' => $userId,
                'period_id' => $periodId,
                'status' => self::STATUS_IN_PROGRESS
            ])->update(['status' => self::STATUS_OVER]);
        }
    }

    /** 判断是否是自动竞拍状态 */
    public static function isAutoBid($userId, $periodId)
    {
        $model = DB::table('auto_bid')->where([
            'user_id' => $userId,
            'period_id' => $periodId,
            'status' => self::STATUS_IN_PROGRESS
        ])->where('remain_times', '>', 0)->first();
        if ($model) {
            $percent = number_format(($model->remain_times / $model->times), 2) * 100;
            if ($percent != 100) {
                $percent = substr($percent, 0, 2);
            }
            return [
                'remain_times' => $model->remain_times,
                'total_times' => $model->times,
                'percent' => $percent
            ];
        }
        return [
            'remain_times' => 0,
            'total_times' => 0,
            'percent' => 0,
        ];
    }
}
