<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('uname')->comment('admin login username');
            $table->string('email')->comment('admin email login account');
            $table->string('phone')->comment('admin phone login account');
            $table->string('password')->comment('login password');
            $table->rememberToken()->comment('remember token');
            $table->timestamps();
            $table->unique(['uname','email','phone']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
