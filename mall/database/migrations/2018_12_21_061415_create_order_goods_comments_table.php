<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->comment('order id');
            $table->string('order_no',32)->default('')->comment('order serial number');
            $table->integer('spu_id')->unsigned()->comment('spu id');
            $table->integer('sku_id')->unsigned()->comment('sku id');
            $table->integer('user_id')->unsigned()->comment('user id');
            $table->string('nickname',64)->comment('user nickname');
            $table->string('comment')->comment('user comment');
            $table->tinyInteger('source')->comment('comment level:1~5');
            $table->string('images')->comment('image path');
            $table->timestamps();
            $table->index(['order_id','order_no','sku_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_goods_comments');
    }
}
