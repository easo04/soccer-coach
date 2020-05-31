<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePratiqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pratique', function (Blueprint $table) {
            $table->increments('id');
            $table->string('theme', 400)->nullable();
            $table->string('endroit', 200)->nullable();
            $table->date('time')->nullable();
            $table->string('temps')->nullable();
            $table->string('effectif')->nullable();
            $table->string('materiel')->nullable();
            $table->string('context', 900)->nullable();           
            $table->set('categorie', ['Technique', 'Tactique', 'Défensive', 'Offensive', 'Organisation du jeu', 'Gardien de but', 'None']);
            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')
                ->references('id')
                ->on('users');
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
        Schema::dropIfExists('pratique');
    }
}
