<?php

namespace App\Admin\Controllers;

use App\Base;
use App\Models\BidType;
use App\Models\Common;
use App\Models\Period;
use App\Models\Product;

use App\Models\ProductType;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class ProductController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('商品管理');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('商品');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }


    public function show()
    {
       // print_r('123213');exit;
       // echo "<script>history.go(-1);</script>";
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('商品');
            $content->description('新建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Product::class, function (Grid $grid) {

            $grid->actions(function ($actions) {
                $actions->disableView();
                $actions->disableDelete();
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->disableExport();
            $grid->filter(function ($filter) {
                // 在这里添加字段过滤器
                $filter->like('title', '标题');
                $filter->in('status', '状态')->select(Common::commonStatus());
                $filter->in('type', '产品类型')->select(ProductType::getList(1));
                $filter->equal('is_shop', '售出类型')->select(Product::sellType());
				$filter->equal('is_popular', '正在热拍')->select(Common::commonStatus());
                $filter->equal('is_recommend', '拍品推荐')->select(Common::commonStatus());
                $filter->equal('is_home_recommend', '首页推荐')->select(Common::commonStatus());
                // 设置created_at字段的范围查询
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '修改时间')->datetime();
            });

            $grid->id('是否正在竞拍【绿=是,红=否】')->display(function ($released) {
                $model = Period::where(['product_id' => $released, 'status' => Period::STATUS_IN_PROGRESS])->first();
                return $model ? '<p style="color: green" >' . $released . '</p>' : '<p style="color: red" >' . $released . '</p>';
            });
            $grid->img_cover('产品封面图')->display(function ($released) {
                return '<a href="' . env('QINIU_URL_IMAGES') . $released . '" target="_blank" ><img src="' .
                    env('QINIU_URL_IMAGES') . $released . '?imageView/1/w/65/h/45" ></a>';
            });
            $grid->title('标题')->color('');
            $grid->sell_price('市场价');
            $grid->bid_step('每次涨价');
            $grid->type('产品类型')->display(function ($released) {
                $res = ProductType::getOne($released, ['name']);
                if (empty($res)) {
                    return '';
                } else {
                    return $res->name;
                }
            });
            $grid->pay_amount('每次竞拍价');
            $grid->buy_by_diff('是否可以差价购')->display(function ($released) {
                return $released ? '是' : '否';
            });

            $grid->status('状态')->display(function ($released) {
                return $released ? '有效' : '无效';
            });
            $grid->is_shop('售出类型')->display(function ($released) {
                return $released ? '购物币' : '竞拍';
            });


            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Product::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('title', '标题')->rules('required', [
                'required' => '请填写产品标题',
            ]);
            $form->text('short_title', '短标题')->rules('required', [
                'required' => '请填写产品短标题',
            ]);
            $form->currency('sell_price', '市场价')->symbol('￥')->rules('required', [
                'required' => '请填写市场价',
            ]);
            $form->currency('init_price', '初始价格')->symbol('￥')->rules('required', [
                'required' => '请填写优惠券金额',
            ])->default(0);
            $form->currency('bid_step', '每次竞拍价格')->symbol('￥')->rules('required', [
                'required' => '请填写市场价',
            ])->default(0.1);
            $form->select('bid_type', '出价类型')->options(BidType::getList(1))->default(1);
            $form->select('type', '产品类型')->options(ProductType::getList(1))->rules('required', [
                'required' => '请填写产品类型',
            ]);
            $form->text('sort', '排序')->default(0)
                ->help('排序的数字越大越靠前');
            $form->image('img_cover', '产品封面图');
            // $form->image('imgs', '产品子图');
            $form->multipleImage('imgs', '产品子图')->removable();
            $form->multipleImage('desc_imgs', '产品详情图')->removable();
            $form->switch('buy_by_diff', '是否可以差价购买')->states(Product::$buyByDiff)->default(1);
            $form->switch('is_recommend', '是否推荐')->states(Product::getIsRecommend())->default(0);
            $form->switch('is_popular', '是否热拍')->states(Product::getIsPopular())->default(0);
            $form->switch('is_home_recommend', '是否首页推荐')->states(Product::getIsHomeRecommend())->default(0);

//            $form->switch('is_shop', '是否加入购物币专区')->states(Product::getIsShop())->default(1);
//            $form->switch('is_bid', '是否加入竞拍列表')->states(Product::getIsBid())->default(1);

            $form->switch('is_shop', '售出类型')->states(Common::getStates('购物币专区', '竞拍列表'))->default(0)
                ->help('加入竞拍列表 或 购物币专区');
            $form->switch('status', '状态')->states(Common::getStates())->default(1)
                ->help('当设置无效时，【竞拍】该产品将终止下一期竞拍，【购物币专区】将不会有该产品');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');

            $form->saved(function (Form $form) {
                $payAmount = BidType::find($form->model()->bid_type)->amount;
                $countdownLength = 10;
                if ($form->model()->type == 1) {
                    $payAmount = 10;
                    $countdownLength = 5;
                }
                $collectionCount = $form->model()->collection_count;
                if ($form->model()->collection_count <= 0) {
                    $collectionCount = rand(100, 9999);
                }
                $status = $form->model()->status;
                if ($form->model()->is_shop == 0 && $status) {
                    DB::table('product')->where(['id' => $form->model()->id])->update([
                        'pay_amount' => $payAmount,
                        'is_bid' => Product::BID_YES,
                        'is_shop' => Product::SHOPPING_NO,
                        'collection_count' => $collectionCount,
                        'countdown_length' => $countdownLength
                    ]);

                    $period = Period::where([
                        'product_id' => $form->model()->id,
                        'status' => Period::STATUS_IN_PROGRESS
                    ])->first();

                    if ($period) {
//                        $error = new MessageBag([
//                            'title' => '操作错误!',
//                            'message' => '该产品正在竞拍，请勿重复添加',
//                        ]);
//                        return back()->with(compact('error'));
                    } else {
                        (new Period())->saveData($form->model()->id);
                    }
                } elseif ($form->model()->is_shop == 1 && $status) {
                    DB::table('product')->where(['id' => $form->model()->id])->update([
                        'pay_amount' => $payAmount,
                        'is_shop' => $status,
                        'collection_count' => $collectionCount,
                        'countdown_length' => $countdownLength
                    ]);
                }
                //清除产品缓存
                Cache::forget('product@find' . $form->model()->id);
            });
        });

    }
}
