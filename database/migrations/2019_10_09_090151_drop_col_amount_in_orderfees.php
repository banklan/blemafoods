<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColAmountInOrderfees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_fees', function (Blueprint $table) {
            $table->dropColumn('amount');
            $table->string('from')->after('id');
            $table->string('to')->after('from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_fees', function (Blueprint $table) {
            //
        });
    }
}
