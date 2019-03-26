<?php
namespace App\Observers;

use App\Jobs\BidTask;
use App\Models\Bid;

/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/7/24
 * Time: 12:08
 */
class BidObserver
{
//    public function saving(Bid $bid)
//    {
//        $bid->end_time = '1996-05-06 00:00:00';
//        if (!$bid->product_id) {
//            // 推送任务到队列
//            dispatch(new BidTask($bid));
//        }
//    }
}