<?php

namespace App\Admin\Controllers;

use App\Base;
use App\Models\Auctioneer;
use Illuminate\Support\MessageBag;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AuctioneerController extends Controller
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

            $content->header('拍卖师');
            // $content->description('/拍卖师列表');

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
            $content->description(trans('admin.edit'));
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
            $content->description(trans('admin.create'));
            $content->body($this->form());
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
        return Admin::grid(Auctioneer::class, function (Grid $grid) {

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
            $grid->name('名称')->color('');
            $grid->tags('标签');
            $grid->certificate('证书');
            $grid->years('工作年限');
            $grid->number('编码');
            $grid->status('状态');
            $grid->unit('单位机构');
            $grid->image('头像');
            $grid->created_by('创建人');
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
        return Admin::form(Auctioneer::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name', '名称')->rules('required', [
                'required' => '请填写拍卖师名称',
            ]);
            $form->text('tags', '标签')->rules('required', [
                'required' => '请填写拍卖师标签',
            ]);
            $form->text('years', '工作年限')->rules('required', [
                'required' => '请填写工作年限',
            ]);
            $form->text('certificate', '证书')->rules('required', [
                'required' => '请填证书',
            ]);
            $form->text('unit', '单位机构')->rules('required', [
                'required' => '请填写单位机构',
            ]);
            $form->hidden('created_by', '创建人')->value(Admin::user()->id);
            $form->image('image');
            $disk = \Storage::disk('qiniu');
            $disk->getDriver()->downloadUrl('file.jpg');
            $form->switch('status', '状态')->states(Base::getStates());
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
