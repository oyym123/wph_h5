<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoBidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_bid', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('times')->comment('出价次数');
            $table->tinyInteger('status')->default('10')->comment('10 = 未开始 ；20 = 进行中 ；30 =已结束');
            $table->integer('period_id')->comment('期数');
            $table->integer('product_id')->comment('产品id')->nullable();
            $table->integer('remain_times')->comment('剩余次数');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_bid');
    }
}
