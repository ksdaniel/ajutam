<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNullableToSolicitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitations', function (Blueprint $table) {
            $table->dateTime('finish_date')->change()->nullable();
            $table->integer("volunteer_id")->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitations', function (Blueprint $table) {
            //
        });
    }
}
