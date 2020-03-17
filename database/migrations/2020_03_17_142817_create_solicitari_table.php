<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitations', function (Blueprint $table) {
            $table->id();

            $table->string("name");
            $table->string("last_name");
            $table->string("phone");
            $table->string("address");
            $table->string("neighborhood");
            $table->string("city");
            $table->string("county");
            $table->string('categories');
            $table->string('emergency');
            $table->string('status');
            $table->text('additional_responses');
            $table->text("observations")->nullable();
            $table->dateTime('finish_date');
            $table->integer("volunteer_id")->index()->unsigned();

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
        Schema::dropIfExists('solicitari');
    }
}
