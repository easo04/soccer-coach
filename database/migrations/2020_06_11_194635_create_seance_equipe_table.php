<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeanceEquipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seance_equipe', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seance_id')->unsigned();
            $table->integer('equipe_id')->unsigned();
            $table->integer('saison_id')->unsigned();
            $table->foreign('seance_id')
                ->references('id')
                ->on('pratique');
            $table->foreign('equipe_id')
                ->references('id')
                ->on('equipes');
            $table->foreign('saison_id')
                ->references('id')
                ->on('saison_equipes');
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
        Schema::table('seance_equipe', function (Blueprint $table) {
            $table->dropForeign('seance_equipe_seance_id_foreign');
            $table->dropForeign('seance_equipe_equipe_id_foreign');
            $table->dropForeign('seance_equipe_saison_id_foreign');
        });

        Schema::drop('seance_equipe');
    }
}
