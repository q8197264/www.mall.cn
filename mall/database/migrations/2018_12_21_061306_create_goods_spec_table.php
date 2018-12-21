<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_spec', function (Blueprint $table) {
            $table->increments('id');
            $table->string('spec_no',50)->default('')->comment('spec serial number');
            $table->string('spec_name',50)->default('')->comment('goods spec');
            $table->timestamps();
            $table->index('spec_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_spec');
    }
}
