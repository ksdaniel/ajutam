<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeneficiaryIdToSolicitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitations', function (Blueprint $table) {
            $table->string('payment_type');
            $table->string('payment_status');
            $table->decimal('payment_value');
<<<<<<< HEAD
            /*$table->integer('beneficiary_id')->index()->unsigned();*/
            $table->foreignId('beneficiary_id')->references('id')->on('beneficiaries');
=======
            $table->bigInteger('beneficiary_id')->index()->unsigned();
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries');
>>>>>>> upstream/master
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
            $table->dropForeign('solicitations_beneficiary_id_foreign');
        });
    }
}
