<?php

namespace App\Models;

use App\Helpers\QiniuHelper;
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
        'created_at'
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
        $evaluates = Evaluate::has('product')->where($where)->offset($this->offset)->limit($this->limit)->inRandomOrder()->get();
        $products = new Product();
        foreach ($evaluates as $evaluate) {
            $product = $products->getCacheProduct($evaluate->product_id);
            $images = [];
            $imgs = json_decode($evaluate->imgs);
            if ($imgs) {
                foreach ($imgs as $key => $img) {
                    if ($key < 9) {
                        $images[] = env('QINIU_URL_IMAGES') . $img;
                    }
                }
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

    public static function getInfo($url = '')
    {
        //初始化
        $curlobj = curl_init();
        //设置访问的url
        curl_setopt($curlobj, CURLOPT_URL, $url);
        //执行后不直接打印出
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
        //  curl_setopt($curlobj, CURLOPT_HEADER, 0);
        //设置https 支持
        // date_default_timezone_get('PRC');   //使用cookies时，必须先设置时区
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, 0);  //终止从服务端验证
        curl_setopt($curlobj, CURLOPT_FOLLOWLOCATION, 1);
        $output = curl_exec($curlobj);  //执行获取内容
        curl_close($curlobj);          //关闭curl
        return $output;
    }

    /** 获取京东评论数据，传入产品id号 */
    public function createEvaluate($productId, $url)
    {
        $randNum = rand(6, 9);
        $period = Period::has('product')
            ->where([
                'product_id' => $productId,
                'status' => Period::STATUS_OVER
            ])
            ->offset(0)->limit($randNum)->orderBy('created_at', 'asc')->get()->toArray();

        if (empty($period)) {
            exit('没有该产品期数');
        }

        preg_match("/com\/(.*)(?).html/", $url, $link);

        $getUrl = 'https://sclub.jd.com/comment/productPageComments.action?productId=' . $link[1] . '&score=0&sortType=5&page=0&pageSize=10&isShadowSku=0&rid=0&fold=1';
        $res = iconv('GBK', 'UTF-8', $this->getInfo($getUrl));
        $arr = json_decode($res, true);
        if (isset($arr['comments'])) {
            $arr = array_slice($arr['comments'], 0, count($period));
            foreach ($arr as $key => $item) {
                if ($item['images']) {
                    $descImage = [];
                    foreach ($item['images'] as $images) {
                        $img = str_replace(['//', '128x96', 'n0/s'], ['', '1280x960', 'n1/s'], $images['imgUrl']);
                        $imgs = QiniuHelper::fetchImg($img)[0]['key'];
                        if ($imgs != null) {
                            $descImage[] = $imgs;
                        }
                    }
                    $time = strtotime($period[$key]['created_at']);
                    $rundTime = rand(86400, 86400 * 3);//模拟1~3天到货时间
                    $date = ($x = ($rundTime + $time)) < time() ? $x : time();
                    $data = [
                        'imgs' => json_encode($descImage),
                        'order_id' => 0,
                        'product_id' => $productId,
                        'period_id' => $period[$key]['id'],
                        'content' => $item['content'],
                        'user_id' => $period[$key]['user_id'] ?: 5957,
                        'created_at' => date('Y-m-d H:i:s', $date)
                    ];
                    self::create($data);
                }
            }
        }
        return ['抓取成功！'];
    }

    /** 获取用户表信息 */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /** 获取拍产品表信息 */
    public function Product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
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
