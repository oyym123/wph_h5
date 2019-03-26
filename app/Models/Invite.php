<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Invite extends Common
{
    use SoftDeletes;
    protected $table = 'invite';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'level_1',
        'level_2',
        'user_id',
    ];

    public function checkoutCode($inviteCode, $userId)
    {
        $user = DB::table('users')->where(['invite_code' => $inviteCode])->first();
//        $flag1 = self::where([
//            'level_1' => $userId,
//            'user_id' => $user->id,
//        ])->first();
//
//        $flag2 = self::where([
//            'level_2' => $userId,
//            'user_id' => $user->id,
//        ])->first();

//        $flag = self::where([
//            'user_id' => $user->id,
//        ])->first();
//
//        if ($flag) {  //不允许乱伦
//            return false;
//        }

        if ($user) {
            return true;
        }
        return false;
    }

    public function saveData($userId, $inviteCode)
    {
        $level_2 = DB::table('users')->where(['invite_code' => $inviteCode])->first();
        $level_1 = DB::table('users')->where(['invite_code' => $level_2->be_invited_code])->first();
        if (empty($level_1) || empty($level_2->be_invited_code)) { //防止数据为空
            $data['level_1'] = 0; //表示是爷爷辈
            $data['level_2'] = $level_2->id; //爸爸辈
        } else {
            $data['level_1'] = $level_1->id;
            $data['level_2'] = $level_2->id;
        }
        $data['user_id'] = $userId; //儿子辈
        self::create($data);
    }

    /** 分成 */
    public function shareMoney($userId, $amount, $orderId)
    {
        $invite = self::where([
            'user_id' => $userId
        ])->first();
        if ($invite) {
            $user = DB::table('users')->where(['id' => $userId])->select('nickname')->first();
            if ($invite->level_1) {
                $data = [
                    'user_id' => $invite->level_1,
                    'type' => self::TYPE_INVITE_CURRENCY,
                    'amount' => $amount * config('bid.divide_proportion_level_1'),
                    'return_proportion' => config('bid.divide_proportion_level_1'),
                    'name' => $user->nickname . '充值了' . $amount . '拍币',
                    'order_id' => $orderId,
                ];
                Income::create($data);
                //分成
                DB::table('users')->where(['id' => $invite->level_1])->increment('invite_currency', $data['amount']);
            }
            if ($invite->level_2) {
                $data = [
                    'user_id' => $invite->level_2,
                    'type' => self::TYPE_INVITE_CURRENCY,
                    'amount' => $amount * config('bid.divide_proportion_level_2'),
                    'return_proportion' => config('bid.divide_proportion_level_2'),
                    'name' => $user->nickname . '充值了' . $amount . '拍币',
                    'order_id' => $orderId,
                ];
                Income::create($data);
                //分成
                DB::table('users')->where(['id' => $invite->level_2])->increment('invite_currency', $data['amount']);
            }
        }
    }

    public function inviteList($userId, $type = 'first')
    {
        if ($type == 'first') {
            $level = self::where([
                'level_2' => $userId
            ])->offset($this->offset)->limit($this->limit)->get()->toArray();
        } else {
            $level = self::where([
                'level_1' => $userId
            ])->offset($this->offset)->limit($this->limit)->get()->toArray();
        }
        $user = [];
        $users = DB::table('users')->whereIn('id', array_column($level, 'user_id'))->get();
        foreach ($users as $u1) {
            $user[] = [
                'nickname' => $u1->nickname,
                'created_at' => $u1->created_at,
            ];
        }
        return [count($level), $user];
    }


    public function detail($userId)
    {
        list($count1, $user1) = $this->inviteList($userId);
        list($count2, $user2) = $this->inviteList($userId, 'second');
        $res = [
            'total_users' => $count1 + $count2,
            'first_level' => $count1,
            'second_level' => $count2,
            'invite_code' => $this->userEntity->invite_code ?: '',
            'first_level_list' => $user1,
            'second_level_list' => $user2,
            'make_money'=>'https://' . $_SERVER["HTTP_HOST"] . '/api/make-money', //如何赚钱地址
        ];
        return $res;
    }
}
