<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no')->comment('order serial number');
            $table->integer('goods_count')->comment('goods count');
            $table->integer('user_id')->unsigned()->comment('user id');
            $table->integer('shop_id')->unsigned()->comment('shop id');
            $table->tinyInteger('trade_status')->comment('trade status');
            $table->tinyInteger('pay_id')->comment('pay mode: 0 cash on delivery | 1 online pay');
            $table->decimal('order_amount',10,2)->comment('order amount');
            $table->decimal('goods_amount',10,2)->comment('goods total amount');
            $table->decimal('shipping_fee',10,2)->comment('shipping fee');
            $table->string('shipping_name',20)->default('')->comment('shipping name');
            $table->tinyInteger('address_id')->comment('user address id');
            $table->string('remark')->comment('user remark');
            $table->tinyInteger('is_commented')->comment('is or no commented');
            $table->dateTime('paytime')->comment('pay time');
            $table->timestamps();
            $table->index(['order_no','pay_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_info');
    }
}
