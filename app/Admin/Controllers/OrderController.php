<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2018/8/17
 * Time: 19:37
 */

namespace App\Admin\Controllers;


use App\Models\Common;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
//use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class OrderController extends Controller
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

            $content->header('订单管理');
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

            $content->header('订单详情');
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

            $content->header('订单详情');
            $content->description('新建');

            //  $content->body($this->form());
        });
    }

    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->body(Admin::show(Order::findOrFail($id), function (Show $show) {
                $show->panel()
                    ->tools(function ($tools) {
                        $tools->disableEdit();
                        $tools->disableList();
                        $tools->disableDelete();
                    });

            }));
        });
        echo "<script>history.go(-1);</script>";
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Order::class, function (Grid $grid) {
			$grid->model()->orderBy('id','desc');
            $grid->filter(function ($filter) {
                // 关联关系查询
                $filter->where(function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('nickname', 'like', "%{$this->input}%");
                    });
                }, '昵称');

                $filter->where(function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('spid', 'like', "%{$this->input}%");
                    });
                }, 'spid');

                $filter->expand();
                $filter->like('sn', '订单号');
                $filter->in('status', '状态')->select(Order::getStatus());
                $filter->in('type', '类型')->select(Order::getType());
                $filter->between('created_at', '创建时间')->datetime();
                $filter->between('updated_at', '修改时间')->datetime();


            });
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
            $grid->buyer_id('买家')->display(function ($released) {

                $user = User::find($released);
                if (!$user) {
                    return '';
                }
                return '<a href="users?id=' . $user->id . '" target="_blank" ><img src="' .
                   Common::getImg($user->avatar) . '?imageView/1/w/65/h/45" ></a>';
				//return '<a href="users?id=' . $user->id . '" target="_blank" >' . $user->nickname . '</a>';
            });
			$grid->user()->spid('渠道来源');
            $grid->pay_amount('支付金额')->sortable();
            //$grid->period_id('期数id')->sortable();
            $grid->product_id('产品图片')->display(function ($released) {
                $product = Product::find($released);
                if ($product) {
                    return '<a href="product?id=' . $product->id . '" target="_blank" ><img src="' .
                        $product->getImgCover() . '?imageView/1/w/65/h/45" ></a>';
                } else {
                    return '';
                }
            });
            $grid->status('状态')->display(function ($released) {
                return Order::getStatus($released);
            });

            $grid->type('类型')->display(function ($released) {
                return Order::getType($released);
            });

            $grid->str_address('收货人地址');
			$grid->str_username('姓名');
			$grid->str_phone_number('电话');
            $grid->shipping_company('快递公司');
            //$grid->shipping_number('快运单号');
            $grid->seller_shipped_at('发货时间');
            $grid->created_at('创建时间');
            //$grid->updated_at('修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Order::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->display('sn', '订单号');
            $form->display('pay_amount', '支付金额');
            $form->select('status', '状态')->options(Order::getStatus());
            $form->text('str_address', '收货人地址');
            $form->text('shipping_company', '快递公司');
            $form->text('shipping_number', '快运单号');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
			$form->display('message', 'formid');
            $form->saved(function (Form $form) {
                if ($form->model()->shipping_number) {
                    DB::table('order')->where(['id' => $form->model()->id])->update([
                        'seller_shipped_at' => date('Y-m-d H:i:s', time()),
                        'status' => Order::STATUS_SHIPPED
                    ]);
					
					if($form->model()->message){
						list($form_id,$open_id,$title)=explode("|",$form->model()->message);
						$appid = env('WEIXIN_APP_ID');
						$secret = env('WEIXIN_SECRET');
						$api = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
						$res = Helper::get($api);
						if (strpos($res, 'access_token') !== false) {
							$res = json_decode($res,true);
							$access_token = $res['access_token'];
							$post = [
								'touser'=>$open_id,
								'form_id'=>$form_id,
								'template_id'=>'FZEKk-Ec2T9x57QjLq_4oIekpof2wPOrUbbE807ZAKs',
								'page'=>'pages/home_page/home_page',
								'data'=>[
									'keyword1'=>['value'=>$title],
									'keyword2'=>['value'=>$form->model()->shipping_company],
									'keyword3'=>['value'=>$form->model()->shipping_number],
									'keyword4'=>['value'=>date('Y-m-d H:i:s', time())],
									'keyword5'=>['value'=>$form->model()->str_address]
									
								]
							];
							$api = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token={$access_token}";
							Helper::post2($api, json_encode($post));
							
						}
					}
                }
            });
        });
    }
}
