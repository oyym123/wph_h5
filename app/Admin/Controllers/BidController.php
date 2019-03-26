<?php

namespace App\Admin\Controllers;

use App\Models\Bid;

use App\Models\Common;
use App\Models\Product;
use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class BidController extends Controller
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

            $content->header('竞拍列表');
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

            $content->header('header');
            $content->description('description');

            // $content->body($this->form()->edit($id));
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

            $content->header('header');
            $content->description('description');

            //  $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Bid::class, function (Grid $grid) {

            $grid->actions(function ($actions) {
                $actions->disableEdit();
                $actions->disableView();
            });

            $grid->disableCreateButton();
            $grid->disableExport();
            $grid->filter(function ($filter) {
                // 在这里添加字段过滤器
                $filter->equal('period_id', '期数id')->integer();
                $filter->like('product_title', '产品标题');
				$filter->like('nickname', '用户昵称');
                $filter->in('status', '状态')->multipleSelect(Common::commonStatus());
                $filter->in('is_real', '是否真人')->multipleSelect(\App\User::getIsReal());
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '修改时间')->datetime();
            });

            $grid->id('ID')->sortable();

            $grid->user_id('用户')->display(function ($released) {
                $user = User::find($released);
                return '<a href="users?id=' . $user->id . '" target="_blank" ><img src="' .
                    Common::getImg($user->avatar) . '?imageView/1/w/65/h/45" ></a>';
            });
            $grid->nickname('昵称');
            $grid->is_real('身份')->display(function ($released) {
                return \App\User::getIsReal($released);
            });

            $grid->period_id('期数id')->display(function ($released) {
				return '<a href="period/'.$released.'/edit" target="_blank" >'.$released.'</a>';
            });
            $grid->pay_amount('支付的金额')->sortable();
            $grid->bid_price('当前价格')->sortable();
            $grid->product_id('产品图片')->display(function ($released) {
                $product = Product::find($released);
                if ($product) {
                    return '<a href="product?id=' . $product->id . '" target="_blank" ><img src="' .
                        $product->getImgCover() . '?imageView/1/w/65/h/45" ></a>';
                } else {
                    return $released;
                }
            });
            $grid->product_title('产品');

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
        return Admin::form(Bid::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
