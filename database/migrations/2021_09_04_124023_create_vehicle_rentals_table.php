<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_rentals', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',21)->nullable();
            $table->integer('prix')->nullable();
            $table->integer('nb_place')->nullable();
            $table->text('image')->nullable();
            $table->unsignedBigInteger('id_type_vehicule_rental');
            $table->foreign('id_type_vehicule_rental')->references('id')->on('vehicle_type_rentals');
            $table->string('statut',5)->nullable();
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
        Schema::dropIfExists('vehicle_rentals');
    }
}
