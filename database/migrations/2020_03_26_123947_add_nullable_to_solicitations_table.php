<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToSolicitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitations', function (Blueprint $table) {
            $table->string("payment_type")->nullable()->charset(null)->change();
            $table->string("payment_status")->nullable()->charset(null)->change();
            $table->string("payment_value")->nullable()->charset(null)->change();
            $table->integer("coordonator_id")->charset(null)->change();

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
