<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_rides', function (Blueprint $table) {
            $table->id();
            $table->string('libelle',21)->nullable();
            $table->string('latitude_depart',21)->nullable();
            $table->string('longitude_depart',21)->nullable();
            $table->string('latitude_arrivee',21)->nullable();
            $table->string('longitude_arrivee',21)->nullable();
            $table->text('depart_name')->nullable();
            $table->text('destination_name')->nullable();
            $table->integer('distance')->nullable();
            $table->string('statut',5)->nullable();
            $table->unsignedBigInteger('user_app_id');
            $table->foreign('user_app_id')->references('id')->on('user_apps');
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
        Schema::dropIfExists('favorite_rides');
    }
}
