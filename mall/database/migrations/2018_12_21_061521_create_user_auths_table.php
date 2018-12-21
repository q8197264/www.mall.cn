<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_auths', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->unsigned()->comment('user id');
            $table->string('grant_type',20)->comment('user type');
            $table->string('identifier')->comment('login account name');
            $table->string('credential')->comment('login password or access_token');
            $table->boolean('unbind')->comment('is unbind account');
            $table->timestamps();
            $table->unique(['grant_type','identifier']);
            $table->index('uid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_auths');
    }
}
