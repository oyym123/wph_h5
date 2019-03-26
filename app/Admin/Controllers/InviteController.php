<?php

namespace App\Admin\Controllers;

use App\Models\Common;
use App\Models\Invite;
use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class InviteController extends Controller
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

            $content->header('推广代理');
            $content->description('');

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

            //  $content->body($this->form()->edit($id));
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
        return Admin::grid(Invite::class, function (Grid $grid) {

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
            });

            $grid->disableCreateButton();
            $grid->disableExport();
            $grid->id('ID')->sortable();
            $grid->level_1('用户')->display(function ($released) {
                if ($released == 0) {
                    return '';
                }
                $user = User::find($released);
                return '<a href="users?id=' . $user->id . '" target="_blank" ><img src="' .
                    Common::getImg($user->avatar) . '?imageView/1/w/65/h/45" ></a>';

            });

            $grid->level_2('徒弟')->display(function ($released) {
                if ($released == 0) {
                    return '';
                }
                $user = User::find($released);
                return '<a href="users?id=' . $user->id . '" target="_blank" ><img src="' .
                    Common::getImg($user->avatar) . '?imageView/1/w/65/h/45" ></a>';
            });

            $grid->user_id('徒孙')->display(function ($released) {
                if ($released == 0) {
                    return '';
                }
                $user = User::find($released);

                return '<a href="users?id=' . $user->id . '" target="_blank" ><img src="' .
                    Common::getImg($user->avatar) . '?imageView/1/w/65/h/45" ></a>';
            });

            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
            $grid->filter(function ($filter) {
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
        return Admin::form(Invite::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
