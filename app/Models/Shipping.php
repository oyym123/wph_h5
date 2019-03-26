<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/8/5
 * Time: 19:47
 */

namespace App\Models;

use App\Helpers\Helper;

class Shipping extends Common
{
    /** 快递信息Api接口 */
    public static function shippingInfo($company, $number)
    {
        $url = 'http://poll.kuaidi100.com/poll/query.do';
        //参数设置
        $post_data = array();
        $post_data["customer"] = 'F4B050C52FE66CE063643F94655459DD';
        $key = 'SwfBMBVr340';
        $post_data["param"] = '{"com":"' . $company . '","num":"' . $number . '"}';
        $post_data["sign"] = md5($post_data["param"] . $key . $post_data["customer"]);
        $post_data["sign"] = strtoupper($post_data["sign"]);
        $o = "";
        foreach ($post_data as $k => $v) {
            $o .= "$k=" . urlencode($v) . "&";        //默认UTF-8编码格式
        }
        $post_data = substr($o, 0, -1);
        return Helper::post($url, $post_data);
    }

    /** 快递日志 */
    public static function shippingLogs($company, $number)
    {
        $redis = app('redis')->connection('first');
        if (empty($company) || empty($number)) {
            return [
                [
                    'title' => '暂无快递信息！',
                    'date_time' => '',
                ]
            ];
        }


        $key = 'kuaidi100' . $company . $number;

        if ($data = json_decode($redis->get($key), true)) {
            return $data;
        }

        $res = json_decode(self::shippingInfo($company, $number), true);
        $newArr = [];

        if (isset($res['message']) && $res['message'] != 'ok') { //没获取到物流信息时防止报错
            $newArr = [
                [
                    'title' => '暂无快递信息！',
                    'date_time' => '',
                ]
            ];
        } else {
            foreach ($res['data'] as $v) {
                $newArr[] = [
                    'title' => $v['context'],
                    'date_time' => $v['time'],
                ];
            }
        }
        $redis->setex($key, 3600, substr(json_encode($newArr), 0, 2000));//数据缓存一小时
        return $newArr;
    }

    public static function companyName($key = 999)
    {
        $data = [
            'auspost' => '澳大利亚邮政',
            'aae' => 'AAE',
            'anxindakuaixi' => '安信达',
            'baifudongfang' => '百福东方',
            'bht' => 'BHT',
            'bangsongwuliu' => '邦送物流',
            'cces' => '希伊艾斯',
            'coe' => '中国东方',
            'chuanxiwuliu' => '传喜物流',
            'canpost' => '加拿大邮政Canada',
            'canpostfr' => '加拿大邮政Canada',
            'datianwuliu' => '大田物流',
            'debangwuliu' => '德邦物流',
            'dpex' => 'DPEX',
            'dhl' => 'DHL',
            'dhlen' => 'DHL-国际件',
            'dsukuaidi' => 'D速快递',
            'disifang' => '递四方',
            'ems' => 'EMS',
            'huitongkuaidi' => '百世汇通',
            'fedex' => 'Fedex',
            'feikangda' => '飞康达物流',
            'feikuaida' => '飞快达',
            'rufengda' => '凡客如风达',
            'fengxingtianxia' => '风行天下',
            'feibaokuaidi' => '飞豹快递',
            'ganzhongnengda' => '港中能达',
            'guotongkuaidi' => '国通快递',
            'guangdongyouzhengwuliu' => '广东邮政',
            'gls' => 'GLS',
            'gongsuda' => '共速达',
            'huiqiangkuaidi' => '汇强快递',
            'tiandihuayu' => '华宇物流',
            'hengluwuliu' => '恒路物流',
            'huaxialongwuliu' => '华夏龙',
            'tiantian' => '天天快递',
            'haiwaihuanqiu' => '海外环球',
            'hebeijianhua' => '河北建华',
            'haimengsudi' => '海盟速递',
            'huaqikuaiyun' => '华企快运',
            'haihongwangsong' => '山东海红',
            'jiajiwuliu' => '佳吉物流',
            'jiayiwuliu' => '佳怡物流',
            'jiayunmeiwuliu' => '加运美',
            'jinguangsudikuaijian' => '京广速递',
            'jixianda' => '急先达',
            'jinyuekuaidi' => '晋越快递',
            'jietekuaidi' => '捷特快递',
            'jindawuliu' => '金大物流',
            'jialidatong' => '嘉里大通',
            'kuaijiesudi' => '快捷速递',
            'kangliwuliu' => '康力物流',
            'kuayue' => '跨越物流',
            'lianhaowuliu' => '联昊通',
            'longbanwuliu' => '龙邦物流',
            'lanbiaokuaidi' => '蓝镖快递',
            'lejiedi' => '乐捷递',
            'lianbangkuaidi' => '联邦快递',
            'lijisong' => '立即送',
            'longlangkuaidi' => '隆浪快递',
            'menduimen' => '门对门',
            'meiguokuaidi' => '美国快递',
            'mingliangwuliu' => '明亮物流',
            'ocs' => 'OCS',
            'ontrac' => 'onTrac',
            'quanchenkuaidi' => '全晨快递',
            'quanjitong' => '全际通',
            'quanritongkuaidi' => '全一快递',
            'quanfengkuaidi' => '全峰快递',
            'sevendays' => '七天连锁',
            'shentong' => '申通快递',
            'shunfeng' => '顺丰快递',
            'santaisudi' => '三态速递',
            'shenghuiwuliu' => '盛辉物流',
            'suer' => '速尔物流',
            'shengfengwuliu' => '盛丰物流',
            'shangda' => '上大物流',
            'shenganwuliu' => '圣安物流',
            'sxhongmajia' => '山西红马甲',
            'saiaodi' => '赛澳递',
            'suijiawuliu' => '穗佳物流',
            'tnt' => 'TNT',
            'tonghetianxia' => '通和天下',
            'ups' => 'UPS',
            'youshuwuliu' => '优速物流',
            'usps' => 'USPS',
            'wanjiawuliu' => '万家物流',
            'wanxiangwuliu' => '万象物流',
            'weitepai' => '微特派',
            'xinbangwuliu' => '新邦物流',
            'xinfengwuliu' => '信丰物流',
            'neweggozzo' => '新蛋奥硕物流',
            'hkpost' => '香港邮政',
            'yuantong' => '圆通速递',
            'yunda' => '韵达快运',
            'yuntongkuaidi' => '运通快递',
            'youzhengguonei' => '邮政小包（国内）',
            'youzhengguoji' => '邮政小包（国际）',
            'yuanchengwuliu' => '远成物流',
            'yafengsudi' => '亚风速递',
            'yibangwuliu' => '一邦速递',
            'yuanweifeng' => '源伟丰快递',
            'yuanzhijiecheng' => '元智捷诚',
            'yuefengwuliu' => '越丰物流',
            'yuananda' => '源安达',
            'yuanfeihangwuliu' => '原飞航',
            'zhongxinda' => '忠信达快递',
            'zhimakaimen' => '芝麻开门',
            'yinjiesudi' => '银捷速递',
            'yitongfeihong' => '一统飞鸿',
            'zhongtong' => '中通速递',
            'zhaijisong' => '宅急送',
            'zhongyouwuliu' => '中邮物流',
            'zhongsukuaidi' => '中速快件',
            'zhengzhoujianhua' => '郑州建华',
            'zhongtianwanyun' => '中天万运'
        ];
        return $key == 999 ? $data : $data[$key];
    }
}