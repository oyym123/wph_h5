<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Evaluate extends Common
{
    use SoftDeletes;

    protected $table = 'evaluate';
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'content',
        'period_id', //返还比例
        'imgs', //使用的金额
        'content',
        'sort',
    ];

    public function saveData($data)
    {
        DB::table('order')->where(['id' => $data['order_id']])->update(['status' => Order::STATUS_COMPLETE]);
        return self::create($data);
    }

    /** 获取晒单列表 */
    public function getList($where = [])
    {
        $data = [];
        $evaluates = Evaluate::where($where)->offset($this->offset)->limit($this->limit)->orderBy('created_at', 'desc')->get();
        $products = new Product();
        foreach ($evaluates as $evaluate) {
            $product = $products->getCacheProduct($evaluate->product_id);
            $images = [];
            $imgs = json_decode($evaluate->imgs);
            foreach ($imgs as $img) {
                $images[] = env('QINIU_URL_IMAGES') . $img;
            }
            $data[] = [
                'id' => $evaluate->id,
                'product_title' => $product->title,
                'content' => $evaluate->content,
                'created_at' => $evaluate->created_at,
                'nickname' => $evaluate->user->nickname,
                'avatar' => $evaluate->user->getAvatar(),
                'imgs' => $images
            ];
        }
        return $data;
    }

    public function detail($id)
    {
        $evaluate = $this->getEvaluate(['id' => $id]);
        $products = new Product();
        $product = $products->getCacheProduct($evaluate->product_id);
        $images = [];
        $imgs = json_decode($evaluate->imgs);
        foreach ($imgs as $img) {
            $images[] = env('QINIU_URL_IMAGES') . $img;
        }
        $data = [
            'id' => $evaluate->id,
            'product_title' => $product->title,
            'img_cover' => $product->getImgCover(),
            'content' => $evaluate->content,
            'created_at' => $evaluate->created_at,
            'nickname' => $evaluate->user->nickname,
            'avatar' => $evaluate->user->getAvatar(),
            'imgs' => $images
        ];
        return $data;
    }

    /** 获取用户表信息 */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /** 获取评论 */
    public function getEvaluate($where = [])
    {
        if ($model = Evaluate::where($where)->first()) {
            return $model;
        }
        self::showMsg('没有晒单！', 4);
    }
}
