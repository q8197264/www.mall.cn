<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('user id');
            $table->string('name',64)->comment('address name');
            $table->string('tel',20)->comment('tel');
            $table->char('phone',11)->comment('phone');
            $table->string('province',20)->commen('province name');
            $table->string('city',20)->comment('city name');
            $table->string('district',20)->comment('district name');
            $table->string('address')->comment('address name');
            $table->char('zipcode',6)->comment('zip code');
            $table->boolean('selected')->comment('is default selected');
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_address');
    }
}
