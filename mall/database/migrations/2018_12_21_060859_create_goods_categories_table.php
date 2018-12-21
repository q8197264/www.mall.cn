<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->comment('category pid');
            $table->string('category_name',50)->comment('category name');
            $table->tinyInteger('sort')->comment('category sort');
            $table->tinyInteger('display')->comment('0 or 1:display or hidden');
            $table->timestamps();
            $table->index(['type_id','sort']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_categories');
    }
}
