<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_sku', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->comment('shop id');
            $table->integer('spu_id')->comment('spu id');
            $table->string('sku_no',50)->comment('sku serial number');
            $table->string('sku_name')->cmment('goods name of specified spec');
            $table->decimal('price',10,2)->comment('goods price of specified spec');
            $table->integer('stock')->comment('goods stock of specified spec');
            $table->tinyInteger('status')->comment('1 or 0:upper or lower frames');
            $table->string('images')->comment('image path');
            $table->timestamps();
            $table->index(['shop_id','spu_id','sku_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_sku');
    }
}
