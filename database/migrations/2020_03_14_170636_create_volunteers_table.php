<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->index()->unsigned();
            $table->string("name");
            $table->string("email");
            $table->string("phone");
            $table->string("city");
            $table->string("address");
            $table->string("neighborhood");
            $table->string("activation_area");
            $table->string("involvement_type");
            $table->string("availability");
            $table->string("availability_details");
            $table->text("observations")->nullable();
            $table->text("geojson")->nullable();
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
        Schema::dropIfExists('volunteers');
    }
}
