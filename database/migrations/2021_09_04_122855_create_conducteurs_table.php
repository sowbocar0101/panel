<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConducteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conducteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom',21)->nullable();
            $table->string('prenom',21)->nullable();
            $table->string('cnib',10)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('mdp',100)->nullable();
            $table->string('latitude',21)->nullable();
            $table->string('longitude',21)->nullable();
            $table->string('email',100)->nullable();
            $table->string('statut_licence',10)->nullable();
            $table->string('statut_nic',10)->nullable();
            $table->string('statut_vehicule',10)->nullable();
            $table->string('online',5)->nullable();
            $table->string('login_type',21)->nullable();
            $table->text('photo')->nullable();
            $table->text('photo_path')->nullable();
            $table->text('photo_licence')->nullable();
            $table->text('photo_licence_path')->nullable();
            $table->text('photo_nic')->nullable();
            $table->text('photo_nic_path')->nullable();
            $table->string('tonotify',5)->nullable();
            $table->text('device_id')->nullable();
            $table->text('fcm_id')->nullable();
            $table->integer('amount')->nullable();
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
        Schema::dropIfExists('conducteurs');
    }
}
