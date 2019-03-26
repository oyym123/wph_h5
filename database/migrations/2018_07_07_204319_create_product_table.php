<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题')->nullable();
            $table->integer('type')->comment('类型')->nullable();
            $table->string('img_cover')->comment('产品封面');
            $table->text('imgs')->comment('json格式图片');
            $table->decimal('sell_price')->comment('售价')->nullable();
            $table->decimal('price_add_length')->default('0.1')->comment('加价长度');
            $table->decimal('init_price')->default('0.00')->comment('初始价格')->nullable();
            $table->integer('countdown_length')->default('10')->comment('倒计时长度')->nullable();
            $table->decimal('bid_step')->default('1')->comment('每次竞拍价格');
            $table->tinyInteger('buy_by_diff')->default('1')->comment('是否可以差价购买');
            $table->string('short_title')->comment('短标题');
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
        Schema::dropIfExists('product');
    }
}
