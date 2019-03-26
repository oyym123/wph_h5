<?php

namespace App\Admin\Controllers;

use App\Models\Article;

use App\Models\Common;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ArticleController extends Controller
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

            $content->header('文章');
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

            $content->header('文章');
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

            $content->header('文章');

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
        return Admin::grid(Article::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->title('标题');
            $grid->type('类型')->display(function ($released) {
                $res = Article::getStatus($released);
                if (empty($res)) {
                    return '';
                } else {
                    return $res;
                }
            });
            $grid->actions(function ($actions) {
                $actions->disableView();
                $actions->disableDelete();
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
        return Admin::form(Article::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title', '标题')->rules('required', [
                'required' => '请填写标题',
            ]);
//            $form->editor('contents', '内容')->rules('required', [
//                'required' => '请填写内容',
//            ]);
            $form->ueditor('contents', '内容')->rules('required', [
                'required' => '请填写内容',
            ]);
            $form->select('type', '文章类型')->options(Article::getStatus());
            $form->switch('status', '状态')->states(Common::getStates())->default(1);
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
