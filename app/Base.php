<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{

    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
 //   protected $dateFormat = 'U';


    public $offset = 0; // 分页
    public $limit = 10; // 分页
    public $userEntity = null; // 用户实体
    public $psize = 20;
    public $params = [];

    const STATUS_DISABLE = 0;   // 无效
    const STATUS_ENABLE = 1;    // 有效

    const STATUS_NEED_REVIEW = 1; //需要审核
    const STATUS_NOT_NEED_REVIEW = 0; //不需要审核

    public static function getStates()
    {
        return [
            'on' => ['value' => self::STATUS_ENABLE, 'text' => '有效', 'color' => 'success'],
            'off' => ['value' => self::STATUS_DISABLE, 'text' => '无效', 'color' => 'danger'],
        ];
    }

    public static function isReview()
    {
        return [
            self::STATUS_NEED_REVIEW => '需要审核',
            self::STATUS_NOT_NEED_REVIEW => '不需要审核',
        ];
    }

    public function createdAt($format = 'Y-m-d H:i:s')
    {
        return date($format, $this->created_at);
    }

    public function updatedAt($format = 'Y-m-d H:i:s')
    {
        return date($format, $this->updated_at);
    }

    public function settlementDate($format = 'Y-m-d H:i:s')
    {
        return date($format, $this->settlement_date);
    }

    /** 时间转换字符串 */
    public function date2String($date, $format = 'Y-m-d')
    {
        return date($format, $date);
    }

    /** 时间转换数值 */
    public function date2Int($attribute, $param)
    {
        !empty($this->$attribute) && $this->$attribute = strtotime($this->$attribute);
    }

}
