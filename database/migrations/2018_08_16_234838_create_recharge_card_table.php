<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargeCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharge_card', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount')->comment('充值金额');
            $table->decimal('gift_amount')->comment('赠送的金额');
            $table->tinyInteger('gift_type')->default('1')->comment('赠送类型 1=拍币');
            $table->tinyInteger('type')->default('1')->comment('充值类型 1=拍币');
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
        Schema::dropIfExists('recharge_card');
    }
}
