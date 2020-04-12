<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendVolunteersTabele extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('volunteers', function (Blueprint $table) {

            $table->string("ci")->nullable();
            $table->string("cnp")->nullable();
            $table->string("loc_domiciliu")->nullable();
            $table->string("str_domiciliu")->nullable();
            $table->string("nr_domiciliu")->nullable();
            $table->string("ap_domiciliu")->nullable();
            $table->string("ip_acord")->nullable();
            $table->dateTime("data_acord")->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            //
        });
    }
}
