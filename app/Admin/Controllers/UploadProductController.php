<?php

namespace App\Admin\Controllers;

use App\Models\BidType;
use App\Models\Common;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\UploadProduct;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;

class UploadProductController extends Controller
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

            $content->header('上传产品');
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

            $content->header('上传产品');
            $content->description('编辑');
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
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
        return Admin::grid(UploadProduct::class, function (Grid $grid) {
            $grid->actions(function ($actions) {
                $actions->disableView();
            });
            $grid->filter(function ($filter) {
                // 在这里添加字段过滤器
                $filter->in('status', '状态')->select(Common::commonStatus());
                $filter->in('product_type', '产品类型')->select(ProductType::getList(1));
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '修改时间')->datetime();
            });
            $grid->id('ID')->sortable();
            $grid->sell_price('市场价')->sortable();
            $grid->jd_url('京东产品详情地址')->display(function ($released) {
                return '<a href="' . $released . '" target="_blank" >' . $released . '</a>';
            });
            $grid->product_type('产品类型')->display(function ($released) {
                return ProductType::getOne($released, ['name'])->name;
            });
            $grid->status('状态')->display(function ($released) {
                return $released ? '有效' : '无效';
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
        return Admin::form(UploadProduct::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->currency('sell_price', '市场价')->symbol('￥')->rules('required', [
                'required' => '请填写市场价',
            ]);
			$form->currency('init_price', '初始价')->symbol('￥')->rules('required', [
                'required' => '请填写初始价',
            ]);
            $form->text('jd_url', '京东产品详情网址')->rules('required', [
                'required' => '请填写京东产品详情网址',
            ]);
            $form->select('product_type', '产品类型')->options(ProductType::getList(1))->rules('required', [
                'required' => '请填写产品类型',
            ]);
            $form->select('bid_type', '出价类型')->options(BidType::getList(1))->default(1);
            $form->switch('is_shop', '售出类型')->states(Common::getStates('购物币专区', '竞拍列表'))->default(0)
                ->help('加入竞拍列表 或 购物币专区');
            $form->switch('status', '状态')->states(Common::getStates())->default(1)
                ->help('当设置无效时，提交后进入草稿状态，有效时提交将会上传产品');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
            $form->saved(function (Form $form) {
                $status = $form->model()->status;
                if ($form->model()->is_shop == 0 && $status) {
                    //竞拍列表
                    Product::getJd($form->model()->id, 'bid');
                } elseif ($form->model()->is_shop == 1 && $status) {
                    //购物币专区
                    Product::getJd($form->model()->id, 'shop');
                }
            });
        });
    }
}
