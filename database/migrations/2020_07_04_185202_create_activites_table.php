<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->set('type', ['match', 'pratique', 'autre']);
            $table->date('date_debut');
            $table->string('heure_debut');
            $table->string('arrival')->nullable();
            $table->string('time')->nullable();
            $table->string('adversaire')->nullable();
            $table->integer('saison_id')->unsigned()->nullable();
            $table->integer('equipe_id')->unsigned();
            $table->integer('terrain_id')->unsigned()->nullable();
            $table->integer('seance_id')->unsigned()->nullable();
            $table->foreign('terrain_id')
                ->references('id')
                ->on('terrains');
            $table->foreign('equipe_id')
                ->references('id')
                ->on('equipes');
            $table->foreign('saison_id')
                ->references('id')
                ->on('saison_equipes');
            $table->foreign('seance_id')
                ->references('id')
                ->on('pratique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activites', function (Blueprint $table) {
            $table->dropForeign('activites_terrain_id_foreign');
            $table->dropForeign('activites_equipe_id_foreign');
            $table->dropForeign('activites_saison_id_foreign');
            $table->dropForeign('activites_seance_id_foreign');
        });
        Schema::drop('activites');
    }
}
