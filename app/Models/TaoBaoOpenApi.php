<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 11:10
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class TaoBaoOpenApi extends Common
{
    /**
     * 发送短信
     */
    public function sms($request)
    {
        AlibabaCloud::accessKeyClient(config('aliyun.access_key_id_sms'), config('aliyun.access_key_secret_sms'))
            ->regionId('cn-hangzhou')// replace regionId as you need
            ->asGlobalClient();
        $code = mt_rand(1000, 9999);
        $smsInsert['type'] = $request['scenes'];
        $smsInsert['status'] = 1;
        $smsInsert['mobile'] = $request['phone'];
        $smsInsert['key'] = $code;
        $smsInsert['created_at'] = time();
        if ($request['scenes'] == 1) { //场景1 注册
            $query = [
                'PhoneNumbers' => $request['phone'],
                'TemplateCode' => config('aliyun.sms_register_tem_code'),
                'SignName' => config('aliyun.sms_sign_name'),
                'TemplateParam' => json_encode(['code' => $code])
            ];
            $smsInsert['user_id'] = 0;
        }

        try {
            $result = AlibabaCloud::rpcRequest()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => $query,
                ])
                ->request();
            if ($result->toArray()['Code'] == 'OK') {
                //发送成功 则记录
                DB::table('sms')->insert($smsInsert);
                return ['status' => 1, 'data' => []];
            } else {
                return ['status' => 0, 'data' => []];
            }
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }
    }
}