<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->integer('niveau')->nullable();
            $table->integer('comment')->nullable();
            $table->string('statut',5)->nullable();
            $table->unsignedBigInteger('conducteur_id');
            $table->foreign('conducteur_id')->references('id')->on('conducteurs');
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
        Schema::dropIfExists('notes');
    }
}
