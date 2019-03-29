<?php

namespace App\H5\Controllers;

use App\Helpers\Helper;
use App\Helpers\QiniuHelper;
use App\Helpers\WXBizDataCrypt;
use App\Http\Requests\BindMobilePost;
use App\Models\Bid;
use App\Models\City;
use App\Models\Evaluate;
use App\Models\Expend;
use App\Models\Income;
use App\Models\Invite;
use App\Models\Order;
use App\Models\Pay;
use App\Models\Period;
use App\Models\UserAddress;
use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterUserPost;
use App\User;
use App\H5\components\WebController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;

class UserController extends WebController
{

    public function index()
    {
        $data = [
            'title' => '注册成功',
            'desc' => '您已成功注册成为微拍行会员!',
            'btn' => '观看视频',
            'url' => '../article'
        ];
        self::showMsg($data);
    }

    /** 注册 */
    public function registerView(Request $request)
    {
//        list($info, $status) = $this->userInfo();
//        if ($status) {
//            return redirect()->action('UserController@center');
//        }
        $invite = DB::table('invite')->where('user_id', session('user_id'))->first();
        if (!empty($invite)) {
            $inviteUserInfo = DB::table('user_info')->where('user_id', $invite->level_1)->first();
        }
        return view('api.user.register', [
            'data' => session('_old_input'),
            'invite_user_mobile' => empty($inviteUserInfo->bind_mobile) ? '' : $inviteUserInfo->bind_mobile,
            'codeError' => $request->input('codeError')
        ]);
    }

    /**
     * @param Request $request
     * @SWG\Get(path="/api/user/info",
     *   tags={"用户中心"},
     *   summary="",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="code", in="query", default="1", description="code", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="nickname", in="query", default="佚名", description="用户昵称", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="avatar", in="query", default="default_user_photo10.png", description="头像地址", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="invite_code", in="query", default="f4eed21cc611d4234466d08b5176fcf8", description="邀请码",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function info()
    {
        //分成
        $request = $this->request;

        $res = $this->weixin($request->code);
        if (!empty($res)) {
            $result = json_decode($res, true);
            $model = DB::table('users')->where(['open_id' => $result['openid'], 'is_real' => User::TYPE_REAL_PERSON])->first();
            $token = md5(md5($result['openid'] . $result['session_key']));

            $avatar = QiniuHelper::fetchImg($request->avatar)[0]['key'];
            $data = [
                'session_key' => $result['session_key'],
                'open_id' => $result['openid'],
                'nickname' => $request->nickname ?: '佚名',
                'name' => $request->nickname ?: '佚名',
                'avatar' => $avatar ?: 'default_user_photo10.png',
                'is_real' => USER::TYPE_REAL_PERSON,
                'token' => $token,
            ];

            if ($model) {
                Redis::hdel('token', $model->token);
                DB::table('users')->where('id', $model->id)->update($data);
            } else {
                $address = Helper::ipToAddress($request->getClientIp());
                list($province, $city) = City::simplifyCity($address['region'], $address['city']);
                $data['ip'] = $address['ip'];
                $data['country'] = $address['country'];
                $data['province'] = $province ?: '北京';
                $data['city'] = $city ?: '';
                $data['invite_code'] = md5(md5(time() . rand(1, 10000)));
                $data['email'] = rand(10000, 99999) . '@163.com';
                $data['gift_currency'] = config('bid.user_gift_currency');
                $data['spid'] = $request->spid ?: '';
                $model = (new User())->saveData($data);
		

                if ($request->invite_code && empty($model->be_invited_code)) {
                    if ((new Invite())->checkoutCode($request->invite_code, $model->id)) {
                        DB::table('users')->where('id', $model->id)->update([
                            'invite_code' => $model->invite_code,
                            'be_invited_code' => $request->invite_code
                        ]);
                        (new Invite())->saveData($model->id, $request->invite_code);
                    }
                }

            }

            Redis::hset('token', $token, $model->id);
            self::showMsg(['token' => $token]);
        } else {
            self::showMsg(['token' => '']);
        }
    }

    /**
     * 批量注册用户
     * http://wph.com/api/user/batch-register
     */
    public function batchRegister()
    {
        $model = new User();
        for ($i = 0; $i < 30; $i++) {
            $model->rebotRegister();
        }
    }

    /** 修改用户信息 */
    public function update()
    {
        list($info, $status) = $this->userInfo();
        foreach ($info as $key => $item) {
            $data[$key] = $item;
        }
        $user = DB::table('users')->where('id', $info->user_id)->first();
        $data['email'] = $user->email;
        return view('api.user.update', ['data' => $data]);
    }

    /** 修改用户信息表单提交 */
    public function updatePost(Request $request)
    {
        $this->weixinWebOauth(); // 需要网页授权登录
        // file_put_contents('/tmp/test.log', '授权登录成功' . PHP_EOL, FILE_APPEND);
        $user = new User();
        list($info, $status) = $this->userInfo();
        $openId = session('wechat_user')['id'];
        if ($user->userUpdate($request->input(), session('user_id'))) {
            foreach ($info as $key => $item) {
                $data[$key] = $item;
            }
            $user = DB::table('users')->where('id', $info->user_id)->first();
            $data['email'] = $user->email;
            return view('api.user.update', ['status' => 1, 'data' => $data]);
        }
    }

    /** 绑定手机号 */
    public function binddingMobile()
    {
        list($info, $status) = $this->userInfo();
        $data = [
            'bind_mobile' => $info->bind_mobile

        ];
        return view('api.user.binding_mobile', ['oldPut' => session('_old_input'), 'data' => $data]);
    }

    /** 绑定手机号提交表单 */
    public function binddingMobilePost(BindMobilePost $request)
    {
        $user = new User();
        list($msg, $status) = $user->bindMobile($request->input(), session('user_id'));
        if ($status < 0) {
            return redirect()->action('UserController@binddingMobile', ['data' => $request->input(), 'codeError' => $msg]);
        }
        return view('api.user.bindmobile_success');
    }

    /**
     * /**
     * @SWG\Get(path="/api/user/center",
     *   tags={"用户中心"},
     *   summary="用户中心",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *                  [avatar] => 头像
     *                  [nickname] => 佚名
     *                  [created_at] => 2018-07-21 00:42:40
     *                  [status] => 状态
     *                  [user_id] => 813259857
     *                  [register_type] => 注册类型
     *                  [bid_currency] => 254.00 （拍币）
     *                  [gift_currency] => 0.00   （赠币）
     *                  [shopping_currency] => 256.00  （购物币）
     *     "
     *   )
     * )
     */
    public function center()
    {
        $this->auth();
        $user = $this->userIdent;
        $data = array(
            'avatar' => $user->getAvatar(),
            'nickname' => $user->nickname,
            'created_at' => $user->created_at,
            'status' => $user->status,
            'user_id' => substr($user->email, 0, strrpos($user->email, '@')) . $user->id,
            'register_type' => User::REGISTER_TYPE_WEI_XIN,
            'bid_currency' => $this->userIdent->bid_currency,
            'gift_currency' => $this->userIdent->gift_currency,
            'invite_currency' => $this->userIdent->invite_currency,
            'shopping_currency' => $this->userIdent->shopping_currency,
        );
        self::showMsg($data);
    }

    /**
     * @SWG\Get(path="/api/user/user-agreement",
     *   tags={"用户中心"},
     *   summary="用户协议",
     *   description="Author: OYYM",
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function userAgreement()
    {
        return view('api.user.user-agreement');
    }

    /**
     * @SWG\Get(path="/api/user/shopping-currency",
     *   tags={"用户中心"},
     *   summary="我的购物币",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function shoppingCurrency()
    {
        $this->auth();
        $income = new Income();
        $res = $income->shoppingCurrency($this->userId) + ['shipping_currency' => $this->userIdent->shopping_currency];
        self::showMsg($res);
    }

    /**
     * @SWG\Get(path="/api/user/property",
     *   tags={"用户中心"},
     *   summary="我的财产",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function property()
    {
        $this->auth();
        $data = [
            'balance_desc' => [
                'id' => 1,
                'title' => '余额说明',
                'img' => '',
                'function' => 'html',
                'params' => [
                    'key' => 'url',
                    'type' => 'String',
                    'value' => 'https://' . $_SERVER["HTTP_HOST"] . '/api/balance-desc',
                ],
            ],
            'bid_currency' => $this->userIdent->bid_currency,
            'gift_currency' => $this->userIdent->gift_currency,
            'shopping_currency' => $this->userIdent->shopping_currency,
            'make_money' => 'https://' . $_SERVER["HTTP_HOST"] . '/api/make-money'
//            'expend' => (new Expend())->detail($this->userId),
//            'income' => (new Income())->detail($this->userId),
        ];
        self::showMsg($data);
    }

    /**
     * @SWG\Get(path="/api/user/property-income",
     *   tags={"用户中心"},
     *   summary="加载更多收益明细信息",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function propertyIncome()
    {
        $this->auth();
        $income = new Income();
        $income->limit = $this->limit;
        $income->offset = $this->offset;
        self::showMsg($income->detail($this->userId));
    }

    /**
     * @SWG\Get(path="/api/user/property-expend",
     *   tags={"用户中心"},
     *   summary="加载更多支出明细信息",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function propertyExpend()
    {
        $this->auth();
        $expend = new Expend();
        $expend->limit = $this->limit;
        $expend->offset = $this->offset;
        self::showMsg($expend->detail($this->userId));
    }

    /**
     * @SWG\Post(path="/api/user/address",
     *   tags={"用户中心"},
     *   summary="收货地址",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *    @SWG\Parameter(name="address_id", in="formData", default="1", description="地址id,当传过来时表示修改",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="user_name", in="formData", default="王小明", description="", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="telephone", in="formData", default="18779284935", description="", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="province", in="formData", default="吉林省", description="", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="city", in="formData", default="通化市", description="", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="area", in="formData", default="东昌区", description="", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="detail_address", in="formData", default="西路103号", description="详细地址", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="postal", in="formData", default="134200", description="邮编", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="is_default", in="formData", default="1", description="是否默认 1=是 ，0= 否", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function address()
    {
        $this->auth();
        $request = $this->request;
        $data = [
            'user_id' => $this->userId,
            'is_default' => $request->is_default,
            'user_name' => $request->user_name,
            'telephone' => $request->telephone,
            'postal' => $request->postal,
            'detail_address' => $request->detail_address,
            'str_address' => $request->province . '||' . $request->city . '||' . $request->area,
        ];
        if ($request->address_id) {
            $data['id'] = $request->address_id;
            if ((new UserAddress())->updateData($data)) {
                self::showMsg('保存成功！');
            } else {
                self::showMsg('保存失败！', 2);
            }
        } else {
            if ((new UserAddress())->saveData($data)) {
                self::showMsg('保存成功！');
            } else {
                self::showMsg('保存失败！', 2);
            }
        }
    }


    /**
     * @SWG\Get(path="/api/user/default-address",
     *   tags={"用户中心"},
     *   summary="获取用户默认地址",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function defaultAddress()
    {
        $this->auth();
        $address = UserAddress::defaultAddress($this->userId);
        $addressInfo = [
            'username' => $address->user_name,
            'telephone' => $address->telephone,
            'address' => str_replace('||', ' ', $address->str_address) . $address->detail_address
        ];
        self::showMsg($addressInfo);
    }

    /**
     * @SWG\Get(path="/api/user/evaluate",
     *   tags={"用户中心"},
     *   summary="我的晒单",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function evaluate()
    {
        $this->auth();
        self::showMsg((new Evaluate())->getList(['user_id' => $this->userId]));
    }

    /**
     * @SWG\Get(path="/api/user/performance",
     *   tags={"用户中心"},
     *   summary="我的绩效",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *                  [total_amount] => 10 总额
     *                   [withdraw] => 10 可提现额
     *                  [already_withdraw] => 0 已提现额
     *                  [income_list] => Array  收益明细
     *                      (
     *                         [0] => Array
     *                           (
     *                              [amount] => 10.00 元
     *                              [created_at] => 2018-08-09 19:34:09
     *                              [title] => 张三充值100拍币
     *                          )
     *                       )
     *                  [withdraw_list] => Array 提现明细
     *                     (
     *                          [0] => Array
     *                          (
     *                              [amount] => 10.00 元
     *                              [created_at] => 2018-08-09 19:34:09
     *                              [status] => 正在处理
     *                          )
     *                      )
     *     "
     *   )
     * )
     */
    public function performance()
    {
        $this->auth();
        $result = (new Income())->performance($this->userId, $this->userIdent->invite_currency);
        $data = [
            'total_amount' => $result['total_amount'],
            'withdraw' => $result['withdraw'],
            'already_withdraw' => $result['already_withdraw'],
//            'income_list' => $result['income'],
//            'withdraw_list' => (new Withdraw())->detail($this->userId),
        ];
        self::showMsg($data);
    }

    /**
     * @SWG\Get(path="/api/user/performance-income",
     *   tags={"用户中心"},
     *   summary="我的绩效加载更多收益明细信息",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function performanceIncome()
    {
        $this->auth();
        self::showMsg((new Income())->detail($this->userId, ['type' => Income::TYPE_INVITE_CURRENCY]));
    }

    /**
     * @SWG\Get(path="/api/user/performance-withdraw",
     *   tags={"用户中心"},
     *   summary="我的绩效加载更多提现明细信息",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function performanceWithdraw()
    {
        $this->auth();
        $result = (new Withdraw())->detail($this->userId);
        self::showMsg($result);
    }

    /**
     * @SWG\Post(path="/api/user/set-withdraw-account",
     *   tags={"用户中心"},
     *   summary="设置提现账号",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="account", in="formData", default="18779284928@163.com", description="设置提现账号", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="username", in="formData", default="王强", description="姓名", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="password", in="formData", default="666666", description="密码", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="confirm_password", in="formData", default="666666", description="确认密码", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function setWithdrawAccount()
    {
        $this->auth();
        $request = $this->request;

        if (!empty($this->userIdent->cashout_password)) {
            self::showMsg('您已经设置过密码，请勿重复设置,如果忘记密码，请联系管理员!', 4);
        }

        if ($request->password != $request->confirm_password) {
            self::showMsg('与确认的密码不一致!', 4);
        }

        $length = mb_strlen($request->password, 'utf8');

        if ($length > 20 || $length < 6) {
            self::showMsg('密码长度,应该在6~20之间!', 4);
        }

        $data = [
            'cashout_account' => $request->account,
            'cashout_name' => $request->username,
            'cashout_password' => $request->password,
        ];

        $model = User::where(['id' => $this->userId])->update($data);
        if ($model) {
            self::showMsg('设置成功', 0);
        } else {
            self::showMsg('设置失败', 4);
        }
    }

    /**
     * @SWG\Post(path="/api/user/withdraw",
     *   tags={"用户中心"},
     *   summary="提现",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="amount", in="formData", default="10", description="提现金额", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="password", in="formData", default="666666", description="密码", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function withdraw()
    {
        $this->auth();
        $request = $this->request;
        if (empty($this->userIdent->cashout_account)) {
            self::showMsg('请您先设置提现账号!', 4);
        }

        if ($request->amount <= 0) {
            self::showMsg('提现金额必须大于0元');
        }
        $withdraw = $this->userIdent->invite_currency;
        if ($request->amount > $withdraw) {
            self::showMsg('大于可提现金额 ' . $withdraw . '元，请重新选择提现金额');
        }

        if ($request->password != $this->userIdent->cashout_password) {
            self::showMsg('密码错误!');
        }

        if ((new Withdraw())->isProcessing($this->userId)) {
            self::showMsg('已申请过一次，请等处理完成后再次申请!');
        }
        $data = [
            'amount' => $request->amount,
            'user_id' => $this->userId,
            'status' => Withdraw::STATUS_PROCESSING,
            'account' => $this->userIdent->cashout_account,
        ];
        if ((new Withdraw())->saveData($data)) {
            self::showMsg('申请提现成功，请等待管理员处理！');
        } else {
            self::showMsg('申请提现失败！');
        }
    }

}
