<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->comment('order id');
            $table->string('order_no',32)->default('')->comment('order serial number');
            $table->integer('spu_id')->unsigned()->comment('spu id');
            $table->integer('sku_id')->unsigned()->comment('sku id');
            $table->integer('shop_id')->unsigned()->comment('shop id');
            $table->integer('number')->comment('number of buy goods');
            $table->decimal('sku_price',10,2)->comment('goods sku price');
            $table->decimal('total_fee',10,2)->comment('the goods total fee: sku_price * number');
            $table->string('images')->default('')->comment('goods images');
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
        Schema::dropIfExists('order_goods');
    }
}
