<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/7/17
 * Time: 11:03
 */

namespace App\H5\Controllers;

use App\Models\AutoBid;
use App\Models\Bid;
use App\H5\components\WebController;
use App\Models\BidSocket;

class BidController extends WebController
{
    /**
     * @SWG\Post(path="/api/bid/bidding",
     *   tags={"竞拍"},
     *   summary="竞拍提交数据",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="period_id", in="formData", default="16", description="期数id", required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="times", in="formData", default="6", description="次数", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="successful operation"
     *   )
     * )
     */
    public function bidding()
    {
        $this->auth();
        if ($this->request->times == 1 || empty($this->request->times)) {
            $bid = new Bid();
            $bid->userIdent = $this->userIdent;
            $bid->userId = $this->userId;
            self::showMsg($bid->personBid($this->request->period_id));
        } else {
            $autoBid = new AutoBid();
            $autoBid->userIdent = $this->userIdent;
            $autoBid->userId = $this->userId;
            self::showMsg($autoBid->submitInfo($this->request));
        }
    }


    /**
     * @SWG\Get(path="/api/bid/record",
     *   tags={"竞拍"},
     *   summary="出价记录",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="period_id", in="query", default="16", description="",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="limit", in="query", default="20", description="个数",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="pages", in="query", default="0", description="页数",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *              [bid_price] => 价格
     *              [bid_time] => 2018-07-26 17:56:40
     *              [nickname] => 昵称
     *              [avatar] => 头像
     *              [area] => 地址
     *              [bid_type] => 0 = 出局 , 1 = 领先
     *     "
     *   )
     * )
     */
    public function record()
    {
        $bid = new Bid();
        if ($this->request->limit) {
            $bid->limit = $this->limit;
        } else {
            $bid->limit = 3;
        }
        if ($this->offset >= 1) {
            self::showMsg('最多显示100条！', 0);
        }
        return view('h5.bid.record', ['data' => $bid->bidRecord($this->request->period_id)]);
    }


    public function latestDeal()
    {
        $bid = new Bid();
        $bid->limit = $this->limit;
        $bid->offset = $this->offset;
        return view('h5.product.past-deals', ['data' => $bid->bidRecord($this->request->product_id)]);
    }

    /**
     * @SWG\Post(path="/api/bid/newest-bid",
     *   tags={"竞拍"},
     *   summary="最新竞拍数据",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="periods", in="formData", default="15,16,17,18,19,20,21,22", description="period_id集合，逗号隔开", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *                  a => period_id期数id
     *                  b => 支付的拍币金额（分1拍币和10拍币）
     *                  c => 投标的价格
     *                  d => 昵称
     *                  e => 拍币类型（1=赠币，2=拍币）
     *                  f => 状态（1=竞拍成功【按钮需要调整为本期结束】，0=竞拍未成功）
     *                  g => 2018-07-27 16:30:04
     *                  h => 9 (倒计时时间)
     *                  i => 100 (出价记录条数)
     *     "
     *   )
     * )
     */
    public function newestBid()
    {
        self::showMsg((new Bid())->newestBid($this->request->periods));
    }

    /**
     * @SWG\Get(path="/api/bid/auto-info",
     *   tags={"竞拍"},
     *   summary="获取自动竞拍数据信息",
     *   description="Author: OYYM",
     *   @SWG\Parameter(name="token", in="header", default="1", description="用户token" ,required=true,
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="period_id", in="query", default="49", description="期数id", required=true,
     *     type="string",
     *   ),
     *   @SWG\Response(
     *       response=200,description="
     *                  [remain_times] => 3 （剩余次数）
     *                  [total_times] => 6  （总次数）
     *                  [percent] => 50  （百分比）
     *     "
     *   )
     * )
     */
    public function autoInfo()
    {
        $this->auth();
        self::showMsg(AutoBid::isAutoBid($this->userId, $this->request->period_id));
    }

    public function bidSocket()
    {
        //长链接
        $ws = new BidSocket("127.0.0.1", "8081");
    }
}