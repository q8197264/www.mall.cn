<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSkuSpecValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_sku_spec_value', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sku_id')->unsigned()->comment('sku id');
            $table->integer('spec_value_id')->unsigned()->comment('spec_value id');
            $table->timestamps();
            $table->index(['sku_id','spec_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_sku_spec_value');
    }
}
