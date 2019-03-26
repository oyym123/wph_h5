<?php

namespace App\Admin\Controllers;

use App\Models\Common;
use App\Models\Income;
use App\Models\Invite;
use App\Models\User;
use App\Models\Withdraw;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
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

            $content->header('提现申请');
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

            $content->header('提现申请');
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

            $content->header('header');
            $content->description('description');

            //   $content->body($this->form());
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
        return Admin::grid(Withdraw::class, function (Grid $grid) {

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->actions(function ($actions) {
                $actions->disableView();
            });

            $grid->disableCreateButton();
            $grid->disableExport();
            $grid->filter(function ($filter) {
                // 在这里添加字段过滤器
                $filter->in('status', '状态')->select(Withdraw::getStatus());
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '修改时间')->datetime();
            });

            $grid->id('ID')->sortable();
            $grid->user_id('用户')->display(function ($released) {
                $user = User::find($released);
                return '<a href="users?id=' . $user->id . '" target="_blank" ><img src="' .
                    Common::getImg($user->avatar) . '?imageView/1/w/65/h/45" ></a>';
            });
            $grid->amount('提现金额')->sortable();
            $grid->account('账号');
            $grid->status('状态')->display(function ($released) {
                return Withdraw::getStatus($released);
            });

            $grid->withdraw_at('提现时间');
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
        return Admin::form(Withdraw::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->display('user_id', '用户ID');
            $form->display('amount', '提现金额');
            $form->display('account', '账号');
            $form->select('status', '状态')->options(Withdraw::getStatus());
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
            $form->saved(function (Form $form) {
                if ($form->model()->status == Withdraw::STATUS_COMPLETED) {
                    DB::table('users')->where(['id' => $form->model()->user_id])->decrement('invite_currency', $form->model()->amount);
                }
            });
        });
    }
}
