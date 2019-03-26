<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default('1')->comment('1 = 赠币收益 2 = 购物币 3 = 拍币')->nullable();
            $table->decimal('amount')->comment('金额')->nullable();
            $table->string('name')->comment('名称');
            $table->tinyInteger('status')->comment('状态');
            $table->integer('product_id')->comment('产品id');
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
        Schema::dropIfExists('income');
    }
}
