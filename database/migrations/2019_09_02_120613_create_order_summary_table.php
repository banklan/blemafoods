<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_summaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->integer('user_id')->unsigned();
            $table->integer('item_count')->unsigned()->nullable();
            $table->integer('services_count')->unsigned()->nullable();
            $table->string('value');
            $table->string('message')->nullable();
            $table->string('order_status');
            $table->string('pymt_mode');
            $table->boolean('pymt_status')->default(0);
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
        Schema::dropIfExists('orders_summaries');
    }
}
