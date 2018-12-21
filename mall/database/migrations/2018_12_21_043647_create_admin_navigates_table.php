<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminNavigatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_navigates', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('cid')->comment('children id');
            $table->smallInteger('pid')->comment('parent id');
            $table->string('cname',20)->comment('backend navigate name');
            $table->tinyInteger('status')->comment('display or hidden:0:1');
            $table->tinyInteger('sort')->comment('navigate sort');
            $table->timestamps();
            $table->index(['cid','pid','sort']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_navigates');
    }
}
