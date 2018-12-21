<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSkuSafeguardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_sku_safeguard', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sku_id')->unsigned()->comment('sku id');
            $table->integer('safeguard_id')->unsigned()->comment('goods safeguard id');
            $table->timestamps();
            $table->index(['sku_id','safeguard_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_sku_safeguard');
    }
}
