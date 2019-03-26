<?php

namespace App\Jobs;

use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class BidTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bid;
    protected $data;

    public function __construct($data)
    {
        // 队列任务构造器中接收了 Eloquent 模型，将会只序列化模型的 ID
        //  $this->bid = $bid;
        $this->data = $data;
        //print_r($data);exit;
    }

    public function handle()
    {
        // 为了避免模型监控器死循环调用，我们使用 DB 类直接对数据库进行操作
        // DB::table('bid')->where('id', '=', $this->bid->id)->update($this->data);
        DB::table('bid')->insert($this->data);
    }
}
