<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSpuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_spu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('spu_no',50)->default('')->comment('goods serial number');
            $table->string('goods_name',50)->default('')->comment('goods name');
            $table->string('description')->default('')->comment('goods description');
            $table->decimal('low_price',10,2)->comment('the goods lower price');
            $table->unsignedSmallInteger('category_id')->comment('category id');
            $table->integer('brand_id')->unsigned()->comment('goods brand id');
            $table->tinyInteger('sale')->comment('upper or lower frames');
            $table->timestamps();
            $table->index(['spu_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_spu');
    }
}
