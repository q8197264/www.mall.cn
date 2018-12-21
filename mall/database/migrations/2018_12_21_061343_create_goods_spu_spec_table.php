<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSpuSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_spu_spec', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('spu_id')->unsigned()->comment('spu id');
            $table->integer('spec_id')->unsigned()->comment('spec id');
            $table->timestamps();
            $table->index(['spu_id','spec_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_spu_spec');
    }
}
