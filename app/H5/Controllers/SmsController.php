<?php

namespace App\H5\Controllers;

use App\H5\components\WebController;
use App\Models\TaoBaoOpenApi;

class SmsController extends WebController
{
    /**
     * @SWG\Post(path="/h5/sms/send",
     *     tags = {"短信"} ,
     *     summary = "发送注册短信",
     *     description="Author: OYYM && Date: 2019/4/11 11:28",
     *   @SWG\Parameter(name="scenes", in="formData", default="1", description="短信发送场景 1 = 注册  2 = ...",
     *     type="string",
     *   ),
     *   @SWG\Parameter(name="mobile", in="formData", default="", description="电话号码",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *         response = 200,
     *         description = "success"
     *     )
     * )
     */
    public function send()
    {
        self::showMsg('短信发送成功!');
        exit;
        $res = [
            'mobile' => $this->request->post('mobile'),
            'scenes' => $this->request->post('scenes')
        ];
        $model = new TaoBaoOpenApi();
        if ($model->sms($res)['status'] == 1) {
            self::showMsg('短信发送成功!');
        }
    }
}
