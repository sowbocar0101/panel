<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_apps', function (Blueprint $table) {
            $table->id();
            $table->string('nom',21)->nullable();
            $table->string('prenom',21)->nullable();
            $table->string('email',100)->nullable();
            $table->string('phone',21)->nullable();
            $table->text('mdp')->nullable();
            $table->string('login_type',21)->nullable();
            $table->text('photo')->nullable();
            $table->text('photo_path')->nullable();
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
        Schema::dropIfExists('user_apps');
    }
}
