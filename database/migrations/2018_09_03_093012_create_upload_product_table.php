<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('jd_url')->comment('京东商品详情网址');
            $table->decimal('sell_price')->comment('价格');
            $table->integer('product_type')->comment('产品类型');
            $table->tinyInteger('is_shop')->comment('时候加入购物区 1=是');
            $table->tinyInteger('is_bid')->comment('时候加入竞拍列表 1=是');
            $table->integer('bid_type')->comment('出价类型id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_product');
    }
}
