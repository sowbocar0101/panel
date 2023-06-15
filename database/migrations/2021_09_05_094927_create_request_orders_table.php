<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_orders', function (Blueprint $table) {
            $table->id();
            $table->text('depart_name')->nullable();
            $table->text('destination_name')->nullable();
            $table->string('latitude_depart',21)->nullable();
            $table->string('longitude_depart',21)->nullable();
            $table->string('latitude_arrivee',21)->nullable();
            $table->string('longitude_arrivee',21)->nullable();
            $table->text('place')->nullable();
            $table->integer('number_poeple')->nullable();
            $table->integer('distance')->nullable();
            $table->string('duree',21)->nullable();
            $table->integer('montant')->nullable();
            $table->text('trajet')->nullable();
            $table->string('statut_paiement',10)->nullable();
            $table->date('date_retour')->nullable();
            $table->time('heure_retour')->nullable();
            $table->string('statut_round',5)->nullable();
            $table->unsignedBigInteger('id_user_app');
            $table->foreign('id_user_app')->references('id')->on('user_apps');
            $table->unsignedBigInteger('id_conducteur');
            $table->foreign('id_conducteur')->references('id')->on('conducteurs');
            $table->unsignedBigInteger('id_payment_method');
            $table->foreign('id_payment_method')->references('id')->on('payment_methods');
            $table->string('statut',10)->nullable();
            $table->boolean('status')->nullable()->default(1);
            $table->boolean('status_del')->nullable()->default(1);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('request_orders');
    }
}
