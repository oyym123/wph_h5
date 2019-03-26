<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctioneerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctioneer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称')->nullable();
            $table->string('image')->comment('头像')->nullable();
            $table->text('tags')->comment('标签');
            $table->string('certificate')->comment('证书')->nullable();
            $table->tinyInteger('years')->comment('工作年限')->nullable();
            $table->Integer('created_by')->comment('创建人');
            $table->string('number')->comment('编号')->nullable();
            $table->tinyInteger('status')->default('1')->comment('状态 0=禁用；1=启用')->nullable();
            $table->string('unit')->comment('单位机构');
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
        Schema::dropIfExists('auctioneer');
    }
}
