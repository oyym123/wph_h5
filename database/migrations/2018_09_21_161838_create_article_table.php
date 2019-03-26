<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('intro')->comment('简介')->nullable();
            $table->text('contents')->comment('内容');
            $table->integer('read_count')->comment('阅读量');
            $table->tinyInteger('status')->default('1')->comment('状态：1 = 有效，0 = 无效');
            $table->integer('created_by')->comment('创建人')->nullable();
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
        Schema::dropIfExists('article');
    }
}
