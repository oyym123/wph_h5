<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2017/11/30
 * Time: 12:03
 */

namespace App\Api\Controllers;

use App\Api\components\WebController;
use App\Helpers\QiniuHelper;
use Illuminate\Support\Facades\Redirect;

class ArticleController extends WebController
{

    function index()
    {
        list($info, $status) = $this->userInfo();
        $data = [
            'video1' => [
                'img' => config('qiniu.url_images') . 'WX20171207-042806.png',
                'video' => QiniuHelper::downloadVideoUrl(config('qiniu.url_videos_private'), 'video_decaishifu11.mp4'),
            ],
            'video2' => [
                'img' => config('qiniu.url_images') . 'WX20171207-045235.png',
                'video' => QiniuHelper::downloadVideoUrl(config('qiniu.url_videos_private'), 'video_neigong11.mp4'),
            ],
            'video3' => [
                'img' => config('qiniu.url_images') . 'WX20171207-045321.png',
                'video' => QiniuHelper::downloadVideoUrl(config('qiniu.url_videos_private'), 'video_neigong22.mp4'),
            ],
            'video4' => [
                'img' => config('qiniu.url_images') . 'WX20171207-video4.png',
                'video' => QiniuHelper::downloadVideoUrl(config('qiniu.url_videos_private'), 'video_neigong23.mp4'),
            ],
            'video5' => [
                'img' => config('qiniu.url_images') . 'WX20171207-video5.png',
                'video' => QiniuHelper::downloadVideoUrl(config('qiniu.url_videos_private'), 'video_neigong24.mp4'),
            ],
            'video6' => [
                'img' => config('qiniu.url_images') . 'WX20171207-video6.png',
                'video' => QiniuHelper::downloadVideoUrl(config('qiniu.url_videos_private'), 'video_neigong25.mp4'),
            ],
        ];

        list($info, $status) = $this->userInfo();
        if ($status) {

            return view('api.member_video', [
                'data' => $data
            ]);
        }

        return Redirect::to('api/user/register-view');
    }

}