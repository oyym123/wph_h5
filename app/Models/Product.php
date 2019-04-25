<?php

namespace App\Models;

use App\Helpers\QiniuHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;


class Product extends Common
{
    //use SoftDeletes;

    protected $table = 'product';

    const BUY_BY_DIFF_NO = 0;
    const BUY_BY_DIFF_YES = 1;

    const SHOPPING_YES = 1; //加入购物币专区
    const SHOPPING_NO = 0;  //不加入购物币专区

    const BID_YES = 1; //加入竞拍列表
    const BID_NO = 0;  //不加入竞拍列表

    const POPULAR_YES = 1; //热门
    const POPULAR_NO = 0;  //不热门

    const RECOMMEND_YES = 1; //推荐
    const RECOMMEND_NO = 0;  //不推荐

    const HOME_RECOMMEND_YES = 1; //首页推荐
    const HOME_RECOMMEND_NO = 0;  //首页不推荐


    public static $buyByDiff = [
        self::BUY_BY_DIFF_NO => '不可差价购',
        self::BUY_BY_DIFF_YES => '可差价购',
    ];

    /** 加入购物币专区 */
    public static function getIsShop($key = 999)
    {
        $data = [
            self::SHOPPING_YES => '加入购物币专区',
            self::SHOPPING_NO => '不加入购物币专区',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    /** 是否推荐 */
    public static function getIsRecommend($key = 999)
    {
        $data = [
            self::RECOMMEND_YES => '推荐',
            self::RECOMMEND_NO => '不推荐',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    /** 是否首页推荐 */
    public static function getIsHomeRecommend($key = 999)
    {
        $data = [
            self::HOME_RECOMMEND_YES => '推荐',
            self::HOME_RECOMMEND_NO => '不推荐',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    /** 是否推荐 */
    public static function getIsPopular($key = 999)
    {
        $data = [
            self::POPULAR_YES => '热门',
            self::POPULAR_NO => '不热门',
        ];
        return $key != 999 ? $data[$key] : $data;
    }


    /** 售出类型 */
    public static function sellType()
    {
        return [
            self::SHOPPING_YES => '购物币专区',
            self::SHOPPING_NO => '竞拍专区'
        ];
    }

    /** 加入购物币专区 */
    public static function getIsBid($key = 999)
    {
        $data = [
            self::BID_YES => '加入竞拍列表',
            self::BID_NO => '不加入竞拍列表',
        ];
        return $key != 999 ? $data[$key] : $data;
    }

    public function setImgsAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['imgs'] = json_encode($pictures);
        }
    }

    public function setDescImgsAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['desc_imgs'] = json_encode($pictures);
        }
    }

    public function getDescImgsAttribute($pictures)
    {
        return json_decode($pictures, true) ?: [];
    }

    public function getImgsAttribute($pictures)
    {
        return json_decode($pictures, true) ?: [];
    }

    /** 获取产品数量 */
    public static function counts($today = 0)
    {
        if ($today) {
            return DB::table('product')->where(['status' => self::STATUS_ENABLE])
                ->whereBetween('created_at', [date('Y-m-d', time()), date('Y-m-d', time()) . ' 23:59:59'])
                ->count();
        } else {
            return DB::table('product')->where(['status' => self::STATUS_ENABLE])->count();
        }
    }

    /** 获取缓存的产品信息 */
    public function getCacheProduct($productId)
    {
        $key = 'product@find' . $productId;
        if ($this->hasCache($key)) {
            return $this->getCache($key);
        } else {
            $data = $this->getProduct($productId);
            return $this->putCache($key, $data, 10);
        }
    }

    public function getImgCover()
    {
        return env('QINIU_URL_IMAGES') . $this->img_cover;
    }

    /** 判断是否是10元专区 */
    public function isTen()
    {
        return $this->type == 1 ? 1 : 0;
    }

    public function getProduct($id)
    {
        if ($model = Product::find($id)) {
            return $model;
        }
        self::showMsg($id . '该产品不存在!', self::CODE_NO_DATA);
    }

    /** 购物币专区 */
    public function shopList()
    {
        $products = Product::where([
            'is_shop' => self::SHOPPING_YES,
            'status' => self::STATUS_ENABLE
        ])->offset($this->offset)->limit($this->limit)->get();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'product_id' => $product->id,
                'title' => self::changeStr($product->title, 29, '...'),
                'sell_price' => $product->sell_price,
                'img_cover' => $product->getImgCover(),
            ];
        }
        return $data;
    }

    /** 购物币专区详情 */
    public function shopDetail($productId)
    {
        $product = $this->getCacheProduct($productId);
        if ($product->is_shop == self::SHOPPING_YES) {
            $collection = new Collection();
            return [
                'product_id' => $product->id,
                'title' => $product->title,
                'sell_price' => $product->sell_price,
                'is_favorite' => $collection->isCollect($this->userId, $product->id),
                'img_cover' => $product->getImgCover(),
                'imgs' => array_merge(self::getImgs($product->imgs), [$product->getImgCover()]),
                'desc_imgs' => self::getImgs($product->desc_imgs),
                'evaluate' => (new Evaluate())->getList(['product_id' => $productId])
            ];
        } else {
            return [];
        }
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


    public static function getJd($uploadId, $flag = '')
    {
        set_time_limit(0);
        $upload = UploadProduct::find($uploadId);
        $payAmount = BidType::find($upload->bid_type)->amount;
        $countdownLength = 10;
        if ($upload->product_type == 1) {
            $payAmount = 10;
            $countdownLength = 5;
        }

        if ($flag == 'shop') {
            $isShop = Product::SHOPPING_YES;
            $isBid = Product::BID_NO;
        } else {
            $isBid = Product::BID_YES;
            $isShop = Product::SHOPPING_NO;
        }
        $url = $upload->jd_url;
        $output = self::getInfo("$url");
        preg_match_all("/cd.jd.com\/description(.*)(?)\'/siU", $output, $desc);

        $descImage = $imgUrls = $descImages = $imgs = [];

        if (!empty($desc[1])) {
            if ($desc[1][0]) {
                $descUrl = 'cd.jd.com/description' . $desc[1][0];
            }
        } else {
            preg_match_all("/cd.jd.com\/qrcode\?skuId=(.*)(?)&/siU", $output, $desc1);
            $descUrl = 'https://dx.3.cn/desc/' . $desc1[1][0];
        }

        $outputDesc = self::getInfo("$descUrl");
        preg_match_all("/\/\/img(.*)(?)(png|jpg)/siU", $outputDesc, $descImg);
        $descImages = array_slice($descImg[0], 0, 6);

        preg_match_all("/data-origin=\"(.*)(?)\" alt=\"(.*)(?)\"/", $output, $titles);
        $title = '';
        if ($titles[2][0]) {
            preg_match_all("/\"jfs(.*)(?)\]/", $output, $name);
            $title = iconv('GBK', 'UTF-8', $titles[2][0]);
            $str = str_replace('"', '', '"jfs' . $name[1][0]);
            $imgUrls = explode(',', $str);
        }

        foreach ($descImages as $image) {
            $img = str_replace('//', '', $image);
            $descImage[] = QiniuHelper::fetchImg($img)[0]['key'];
        }

        foreach ($imgUrls as $imgUrl) {
            $imgs[] = QiniuHelper::fetchImg('img13.360buyimg.com/n1/s450x450_' . $imgUrl)[0]['key'];
        }
        $model = new Product();
        $model->title = $title;
        $model->type = $upload->product_type;
        $model->short_title = $title;
        $model->collection_count = rand(500, 9999);
        $model->img_cover = $imgs[0];
        $model->imgs = $imgs;
        $model->desc_imgs = $descImage;
        $model->is_shop = $isShop;
        $model->pay_amount = $payAmount;
        $model->sell_price = $upload->sell_price;
        $model->status = self::STATUS_ENABLE;
        $model->init_price = $upload->init_price;
        $model->countdown_length = $countdownLength;
        $model->bid_step = 0.1;
        $model->buy_by_diff = 1;
        $model->created_at = date('Y-m-d H:i:s', time());
        $model->updated_at = date('Y-m-d H:i:s', time());
        $model->is_bid = $isBid;
        $model->bid_type = $upload->bid_type; //出价类型id ，默认为1
        $model->upload_id = $uploadId; //出价类型id ，默认为1
        if ($model->save() && $isBid == Product::BID_YES) {
            (new Period())->saveData($model->id); //生成期数
        }
    }

    public function getJDInfo()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.m.jd.com/client.action?functionId=uniformRecommend&clientVersion=7.1.2&build=61628&client=android&d_brand=OnePlus&d_model=ONEPLUSA3010&osVersion=4.4.4&screen=1920*1080&partner=lmobile030&androidId=7025047360735836&installtionId=ee1408ade8e44712a99d61935cabc75a&sdkVersion=19&lang=zh_CN&uuid=860525367676637-08002701ab0e&area=5_274_3206_51302&networkType=wifi&wifiBssid=unknown&st=1535893840198&sign=044372b854371302e643a3bd3d1a13d6&sv=121 ",
            //  CURLOPT_URL => "http://api.m.jd.com/client.action?functionId=uniformRecommend&clientVersion=7.1.2&build=61628&client=android&d_brand=OnePlus&d_model=ONEPLUSA3010&osVersion=4.4.4&screen=1920*1080&partner=lmobile030&androidId=7025047360735836&installtionId=ee1408ade8e44712a99d61935cabc75a&sdkVersion=19&lang=zh_CN&uuid=860525367676637-08002701ab0e&area=5_274_3206_51302&networkType=wifi&wifiBssid=unknown&st=1535885439001&sign=15b504aa2b2b6c47abe25b1f97f83915&sv=110",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            //CURLOPT_POSTFIELDS => "body=%7B%22category%22%3A%229987%3B653%3B655%22%2C%22flt%22%3A%220%22%2C%22page%22%3A1%2C%22pageSize%22%3A36%2C%22shopId%22%3A%22583194%22%2C%22skus%22%3A%5B%2230833080863%22%5D%2C%22source%22%3A14%2C%22venderId%22%3A%22220891%22%7D",
            CURLOPT_POSTFIELDS => 'body=%7B%22category%22%3A%229987%3B830%3B867%22%2C%22flt%22%3A%220%22%2C%22page%22%3A1%2C%22pageSize%22%3A36%2C%22shopId%22%3A%22627328%22%2C%22skus%22%3A%5B%2218022692663%22%5D%2C%22source%22%3A14%2C%22venderId%22%3A%22631930%22%7D&',
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "cookies: whwswswws=0f717d051751ce5b23b1d4e5290a844f48830e6fe7afa0e6e5b8ba3970;",
                "postman-token: f58d92c4-7dd6-6a11-220b-597bd3799df3"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
