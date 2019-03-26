<?php

namespace App\Admin\Controllers;

use App\Models\BidType;

use App\Models\Common;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class BidTypeController extends Controller
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

            $content->header('出价分类');
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

            $content->header('出价分类');
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

            $content->header('出价分类');
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
        return Admin::grid(BidType::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->actions(function ($actions) {
                $actions->disableView();
            });
            $grid->name('名称');
            $grid->disableExport();
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
        return Admin::form(BidType::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '名称')->rules('required', [
                'required' => '请填写出价分类名称',
            ]);
            $form->currency('amount', '价格')->symbol('￥')->rules('required', [
                'required' => '请填写价格',
            ]);
            $form->switch('status', '状态')->states(Common::getStates())->default(1);
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
