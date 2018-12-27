<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsCommentImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods_comment_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('comment_id')->comment('comment id');
            $table->string('path')->default('')->comment('user goods comment image path');
            $table->timestamps();
            $table->index('comment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_goods_comment_images');
    }
}
