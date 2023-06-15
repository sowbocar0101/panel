<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand',100)->nullable();
            $table->string('model',100)->nullable();
            $table->string('color',21)->nullable();
            $table->string('numberplate',100)->nullable();
            $table->integer('passenger')->nullable();
            $table->unsignedBigInteger('conducteur_id');
            $table->foreign('conducteur_id')->references('id')->on('conducteurs');
            $table->unsignedBigInteger('id_type_vehicule');
            $table->foreign('id_type_vehicule')->references('id')->on('vehicle_types');
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
        Schema::dropIfExists('vehicles');
    }
}
