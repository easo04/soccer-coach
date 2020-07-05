<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaisonEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saison_equipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->integer('equipe_id')->unsigned();
            $table->foreign('equipe_id')
                ->references('id')
                ->on('equipes');
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
        Schema::table('saison_equipes', function (Blueprint $table) {
            $table->dropForeign('saison_equipes_equipe_id_foreign');
        });

        Schema::drop('saison_equipes');
    }
}
