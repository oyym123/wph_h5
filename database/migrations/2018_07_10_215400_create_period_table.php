<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('产品ID')->nullable();
            $table->string('code')->comment('期数代码')->nullable();
            $table->tinyInteger('status')->default('1')->comment('状态0=未开始；1=进行中；2=已拍完')->nullable();
            $table->integer('succe_bidder_id')->comment('中标者id');
            $table->integer('order_id')->comment('订单id');
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
        Schema::dropIfExists('period');
    }
}
