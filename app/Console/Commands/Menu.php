<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Api\components\WebController;

// php artisan make:command Menu --command=menu:set
class Menu extends Command
{
    /**
     *
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '微信菜单管理';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $app = WebController::weixin();

        $buttons = [
            [
                "name" => "微拍行",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "集团介绍",
                        "key" => "11"
                    ],
                    [
                        "type" => "click",
                        "name" => "集团新闻",
                        "key" => "12"
                    ],
                    [
                        "type" => "click",
                        "name" => "生态产业园",
                        "key" => "13"
                    ],
                    [
                        "type" => "click",
                        "name" => "沉香文化",
                        "key" => "14"
                    ],
                    [
                        "type" => "click",
                        "name" => "诚聘英才",
                        "key" => "15"
                    ],
                ],
            ],
            [
                "name" => "沉香产品",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "沉香烟宝",
                        "key" => "21"
                    ],
                    [
                        "type" => "click",
                        "name" => "沉香养生酒",
                        "key" => "22"
                    ],
                    [
                        "type" => "click",
                        "name" => "沉香女性用品",
                        "key" => "23"
                    ],
                    [
                        "type" => "click",
                        "name" => "沉香禅茶",
                        "key" => "24"
                    ],
                    [
                        "type" => "click",
                        "name" => "其他产品",
                        "key" => "25"
                    ],
                ],
            ],
            [
                "name" => "用户系统",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "填写资料",
                        "url" => config('app.url') . "/api/user/register-view"
                    ],
                    [
                        "type" => "view",
                        "name" => "用户中心",
                        "url" => config('app.url') . "/api/user/center"
                    ],
                    /*
                    [
                        "type" => "view",
                        "name" => "礼品兑换",
                        "url" => config('app.url') . "/api/point/exchange"
                    ],
                    */
                    [
                        "type" => "view",
                        "name" => "视频中心",
                        "url" => config('app.url') . "/api/article"
                    ],
                    [
                        "type" => "view",
                        "name" => "我要推广",
                        "url" => config('app.url') . "/api/invite"
                    ],
                    [
                        "type" => "view",
                        "name" => "在线商城",
                        "url" => "https://weidian.com/?userid=348158125&infoType=1"
                    ],
                ],
            ],
        ];
        $app->menu->add($buttons);
    }
}
