<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_rents', function (Blueprint $table) {
            $table->id();
            $table->integer('nb_jour')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('contact',21)->nullable();
            $table->unsignedBigInteger('id_vehicule_rental');
            $table->foreign('id_vehicule_rental')->references('id')->on('vehicle_rentals');
            $table->unsignedBigInteger('id_user_app');
            $table->foreign('id_user_app')->references('id')->on('user_apps');
            $table->string('statut',100)->nullable();
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
        Schema::dropIfExists('vehicle_rents');
    }
}
