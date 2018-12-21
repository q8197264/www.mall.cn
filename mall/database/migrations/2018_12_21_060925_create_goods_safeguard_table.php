<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSafeguardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_safeguard', function (Blueprint $table) {
            $table->increments('id');
            $table->string('safeguard_name')->comment('安全保障服务名称');
            $table->decimal('price',10,2)->comment('服务价格');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_safeguard');
    }
}
