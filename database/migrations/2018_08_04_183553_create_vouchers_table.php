<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('产品id');
            $table->tinyInteger('status')->comment('状态：1 = 可用 ；2=已使用；');
            $table->dateTime('expired_at')->comment('最新过期时间');
            $table->text('content')->comment('json格式的购物券数据');
            $table->decimal('amount')->comment('金额');
            $table->integer('count')->comment('数量');
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
        Schema::dropIfExists('vouchers');
    }
}
