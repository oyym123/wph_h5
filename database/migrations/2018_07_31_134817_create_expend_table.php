<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expend', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->tinyInteger('type')->default('1')->comment('1 = 赠币收益 2 = 购物币 3 = 拍币');
            $table->decimal('amount')->comment('金额');
            $table->string('name')->comment('名称');
            $table->tinyInteger('status')->default('1');
            $table->integer('product_id')->comment('产品id')->nullable();
            $table->integer('period_id')->comment('期数id');
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
        Schema::dropIfExists('expend');
    }
}
