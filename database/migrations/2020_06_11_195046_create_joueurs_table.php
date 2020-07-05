<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoueursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joueurs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->nullable();
            $table->integer('equipe_id')->unsigned();
            $table->integer('users_id')->unsigned()->nullable();
            $table->set('position1', ['G', 'DFC', 'DFD', 'DFG', 'MC', 'MOC', 'MD', 'MG', 'ATT', 'AG', 'AD', 'AC']);
            $table->set('position2', ['G', 'DFC', 'DFD', 'DFG', 'MC', 'MOC', 'MD', 'MG', 'ATT', 'AG', 'AD', 'AC'])->nullable();
            $table->set('position3', ['G', 'DFC', 'DFD', 'DFG', 'MC', 'MOC', 'MD', 'MG', 'ATT', 'AG', 'AD', 'AC'])->nullable();
            $table->foreign('users_id')
                ->references('id')
                ->on('users');
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
        Schema::table('joueurs', function (Blueprint $table) {
            $table->dropForeign('joueurs_equipe_id_foreign');
			$table->dropForeign('joueurs_users_id_foreign');
        });

        Schema::drop('joueurs');
    }
}
