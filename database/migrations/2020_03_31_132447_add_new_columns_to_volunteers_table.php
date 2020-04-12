<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->text("screening_questions")->nullable();
            $table->string("transportation_options")->nullable();
            $table->string("age_range")->nullable();
            $table->string("address_no")->nullable();
            $table->string("address_bl")->nullable();
            $table->string("address_sc")->nullable();
            $table->string("address_ap")->nullable();
            $table->boolean("acord_termeni")->default(0);
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
