<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->bigIncrements('code')->comment('area code');
            $table->string('name')->comment('region/city/province name');
            $table->tinyInteger('level')->comment('1~5 level');
            $table->bigInteger('pcode')->comment('parent area code');
            $table->timestamps();
            $table->index(['name','level','pcode']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
