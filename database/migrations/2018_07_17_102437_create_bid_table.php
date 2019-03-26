<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('产品id')->nullable();
            $table->integer('period_id')->comment('期数id')->nullable();
            $table->decimal('bid_price')->comment('投标竞价');
            $table->integer('user_id')->comment('竞价人id');
            $table->tinyInteger('status')->comment('状态：1 = 成功，0 = 未成功')->nullable();
            $table->decimal('bid_step')->comment('投标额度');
            $table->string('nickname')->comment('昵称');
            $table->string('product_title')->comment('产品标题');
            $table->dateTime('end_time')->comment('结束时间');
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
        Schema::dropIfExists('bid');
    }
}
