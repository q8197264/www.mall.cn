<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsinged()->comment('user id');
            $table->integer('sku_id')->unsigned()->comment('goods_sku id');
            $table->integer('spu_id')->unsigned()->comment('goods_spu id');
            $table->integer('shop_id')->unsigned()->comment('shop id');
            $table->decimal('add_price',10,2)->comment('Price when join the cart');
            $table->integer('spu_numbers')->comment('Want buy number of goods');
            $table->tinyInteger('status')->comment('0:valid/1:invalid/2:non-exists...');
            $table->tinyInteger('selected')->comment('Is it selected for submit and create order');
            $table->timestamps();
            $table->unique(['user_id','sku_id','spu_id']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
