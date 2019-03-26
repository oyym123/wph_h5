<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\User;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Collapse;
use Illuminate\Support\MessageBag;

class UserController extends Controller
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

            $content->header('用户管理');
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

            $content->header('会员管理');
            $content->description('修改');

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
            $content->header('会员管理');
            $content->description('创建会员');

            $model = Admin::form(User::class, function (Form $form) {
                $form->display('id', 'ID');
                $form->text('name', '名字');
                $form->text('email', '邮箱');
                $form->image('avatar', '头像');
                $form->currency('invite_currency', '推广币');
                $form->currency('shopping_currency', '购物币');
                $form->currency('gift_currency', '赠币');
                $form->currency('bid_currency', '拍币');
                $form->switch('status', '状态')->states(Common::getStates())->default(1);
                $form->display('created_at', '创建时间');
                $form->display('updated_at', '修改时间');
                $form->saved(function (Form $form) {
                    $payAmount = $form->model()->type == 1 ? 10 : 1;
                    $success = new MessageBag([
                        'title' => 'title...',
                        'message' => 'message....',
                    ]);
                    return back()->with(compact('success'));
                });
            });
            $content->body($model);
        });

    }


    public function show()
    {
        echo "<script>history.go(-1);</script>";
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {
            //
            $grid->model()->orderBy('created_at','desc');
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableView();
            });

            $grid->disableCreateButton();
            $grid->disableExport();
            $grid->id('ID')->sortable();
            // $grid->email('邮箱');
            $grid->avatar('头像')->display(function ($released) {
                return '<a href="' . env('QINIU_URL_IMAGES') . $released . '" target="_blank" ><img src="' .
                    env('QINIU_URL_IMAGES') . $released . '?imageView/1/w/65/h/45" ></a>';
            });
            $grid->name('昵称');
            $grid->bid_currency('拍币')->sortable();
            $grid->shopping_currency('购物币')->sortable();
            $grid->invite_currency('推广币')->sortable();
            $grid->gift_currency('赠币')->sortable();
            $grid->cashout_account('提现账号');
            $grid->cashout_name('提现账号名称');
			$grid->spid('来源');
            $grid->status('状态')->display(function ($released) {
                return $released ? '有效' : '无效';
            });
            $grid->is_real('身份')->display(function ($released) {
                return User::getIsReal($released);
            });

            $grid->province('省');
            $grid->city('市');

            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                $filter->like('nickname', '昵称');
				$filter->like('spid', '来源');
                $filter->in('is_real', '身份')->select(User::getIsReal());
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '修改时间')->datetime();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name', '名字');
            $form->text('email', '邮箱');
            $form->image('avatar', '头像');
            $form->currency('invite_currency', '推广币');
            $form->currency('shopping_currency', '购物币');
            $form->currency('gift_currency', '赠币');
            $form->currency('bid_currency', '拍币');
            $form->switch('status', '状态')->states(Common::getStates())->default(1);
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
//            $form->text('role_id', '角色');
        });
    }
}
