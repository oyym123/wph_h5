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
use App\Models\Upload;
use App\Models\UserAddress;
use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterUserPost;
use App\User;
use App\H5\components\WebController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;

class UserController extends WebController
{
    //初始化
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $nologin = ['registerView', 'loginView', 'login', 'register', 'checkSms'];
        //在该数组里的方法名，都不需要身份验证
        if (!in_array($this->getMName(), $nologin)) {
            $this->auth();
        }
    }

    //注册视图
    public function registerView()
    {
        return view('h5.user.register');
    }

    //提交注册信息
    public function register()
    {
        $request = $this->request;
        $token = md5(time());
        $data = [
            'session_key' => $token,
            'open_id' => '',
            'nickname' => $this->request->post('mobile') ?: '佚名',
            'name' => $this->request->post('mobile') ?: '佚名',
            'avatar' => 'default_user_photo10.png',
            'is_real' => USER::TYPE_REAL_PERSON,
            'token' => $token,
            'mobile' => $this->request->post('mobile'),
        ];

        $user = DB::table('users')->where([
            'mobile' => $this->request->post('mobile')
        ])->first();  //查询是否已经存在手机号，若有则是忘记密码进行重置操作

        //密码规则
        if (mb_strlen($request->pwd) < 6) {
            self::showMsg('密码最少6位', -1);
        }

        if (!empty($user)) { //重置密码
            list($msg, $status) = \App\Models\User::smsCheck([
                'type' => 1,
                'mobile' => $this->request->post('mobile'),
                'sms_code' => $this->request->post('code'),
            ]);

            if ($status < 0) {
                self::showMsg($msg, -1);
            }
            DB::table('users')->where('id', $user->id)->update(['password' => md5($request->pwd)]);
            self::showMsg('密码重置成功!');
        } else { //进行注册
            $address = Helper::ipToAddress($request->getClientIp());
            list($province, $city) = City::simplifyCity($address['region'], $address['city']);
            $data['ip'] = $address['ip'];
            $data['country'] = $address['country'];
            $data['province'] = $province ?: '北京';
            $data['city'] = $city ?: '';
            $data['email'] = rand(10000, 99999) . '@163.com';
            $data['gift_currency'] = config('bid.user_gift_currency');
            $data['spid'] = $request->spid ?: '';
            $data['password'] = md5($request->pwd);
            $model = (new User())->saveData($data);
            //保存邀请码【随机生成唯一码 119087 + 用户id】
            $invite_code = 119087 + $model->id;
            DB::table('users')->where('id', $model->id)->update(['invite_code' => $invite_code]);
            if ($request->invite_code && empty($model->be_invited_code)) {
                if ((new Invite())->checkoutCode($request->invite_code, $model->id)) {
                    DB::table('users')->where('id', $model->id)->update([
                        'invite_code' => $invite_code,
                        'be_invited_code' => $request->invite_code
                    ]);
                    (new Invite())->saveData($model->id, $request->invite_code);
                }
            }
            session()->put('user_info', json_encode(DB::table('users')->where('id', $model->id)->first()));
            self::showMsg('注册成功!');
        }
    }

    //检测短信验证码
    public function checkSms()
    {
        list($msg, $status) = \App\Models\User::smsCheck([
            'type' => 1,
            'mobile' => $this->request->post('mobile'),
            'sms_code' => $this->request->post('code'),
        ]);

        if ($status < 0) {
            self::showMsg($msg, -1);
        } else {
            self::showMsg('ok');
        }
    }

    //登入视图
    public function loginView()
    {
        return view('h5.user.login');
    }

    //提交登入信息
    public function login()
    {
        $request = $this->request;
        $user = DB::table('users')->where([
            'mobile' => $request->mobile,
            'password' => md5($request->pwd)
        ])->first();

        if ($user) {
            session()->put('user_info', json_encode($user));
            session()->save(); //如果后面执行了exit等终止操作 则需要次方法强制保存
            self::showMsg('登入成功!');
        } else {
            self::showMsg('账号或密码错误!', -1);
        }
    }

    /** 修改用户信息视图 */
    public function updateView()
    {
        return view('h5.user.update');
    }

    /** 修改用户信息 */
    public function update()
    {
        $request = $this->request;
        $data['nickname'] = $request->nickname ?: $this->userIdent->nickname;
        $img = Upload::oneImg($this->request->img);
        $data['avatar'] = $img ?: $this->userIdent->avatar;
        $user = DB::table('users')->where('id', $this->userId)->update($data);
        if ($img || empty($request->nickname)) {
            return redirect('/h5/user/my-info');
        } else {
            self::showMsg('修改成功!');
        }
    }

    /** 基本信息界面 */
    public function myInfo()
    {
        $user = $this->userIdent;
        $data = [
            'avatar' => $user->getAvatar(),
        ];
        return view('h5.user.my-info', $data);
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
        $user = $this->userIdent;
        $data = array(
            'avatar' => $user->getAvatar(),
            'nickname' => $user->nickname,
            'created_at' => $user->created_at,
            'status' => $user->status,
            'user_id' => substr($user->email, 0, strrpos($user->email, '@')),
            'register_type' => User::REGISTER_TYPE_WEI_XIN,
            'bid_currency' => $this->userIdent->bid_currency,
            'gift_currency' => $this->userIdent->gift_currency,
            'invite_currency' => $this->userIdent->invite_currency,
            'shopping_currency' => $this->userIdent->shopping_currency,
            'user_center_active' => 1
        );
        return view('h5.user.center', $data);
    }

    /** 退出登入  */
    public function loginOut()
    {
        session()->forget('user_info');
        self::showMsg('退出成功!');
    }

    /**
     * @SWG\Get(path="/api/user/setup-list",
     *     tags = {"用户中心"} ,
     *     summary = "设置列表",
     *     description="Author: OYYM && Date: 2019/4/13 13:44",
     *     @SWG\Response(
     *         response = 200,
     *         description = "success"
     *     )
     * )
     */
    public function setupList()
    {
        return view('h5.user.setup');
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
        return view('h5.user.property', $data);
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

        $expend = new Expend();
        $expend->limit = $this->limit;
        $expend->offset = $this->offset;
        self::showMsg($expend->detail($this->userId));
    }

    /** 地址视图 */
    public function addressView()
    {
        return view('h5.user.address');
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
        $request = $this->request;
//        print_r($request->post());exit;
        $data = [
            'user_id' => $this->userId,
            'is_default' => $request->is_default ?: 0,
            'user_name' => $request->addressname,
            'telephone' => $request->mobile,
            'postal' => $request->postal,
            'detail_address' => $request->addressdata,
            'str_address' => str_replace(' ', '||', $request->citys),
        ];
        if ($request->address_id) {
            $data['id'] = $request->address_id;
            if ((new UserAddress())->updateData($data)) {
                self::showMsg('保存成功！');
            } else {
                self::showMsg('保存失败！', -1);
            }
        } else {
            if ((new UserAddress())->saveData($data)) {
                self::showMsg('保存成功！');
            } else {
                self::showMsg('保存失败！', -1);
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
