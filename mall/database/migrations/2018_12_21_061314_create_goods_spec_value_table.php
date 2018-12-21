<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSpecValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_spec_value', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('spec_id')->comment('goods spec id');
            $table->integer('spec_value')->default(0)->comment('goods spec value');
            $table->timestamps();
            $table->index('spec_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_spec_value');
    }
}
