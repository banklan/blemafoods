<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->after('email');
            $table->string('alt_phone')->after('phone')->nullable();
            $table->string('address')->after('alt_phone');
            $table->bigInteger('location_id')->after('address');
            $table->string('area_code')->after('location_id')->nullable();
            $table->boolean('status')->after('area_code')->default(1);

            // $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('alt_phone');
            $table->dropColumn('address');
            $table->dropColumn('location_id');
            $table->dropColumn('area_code');
            $table->dropColumn('status');

        });
    }
}
