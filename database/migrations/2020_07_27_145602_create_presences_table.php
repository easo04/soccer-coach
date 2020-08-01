<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->increments('id');
            $table->set('presence', ['present', 'absent', 'none']);
            $table->date('date_last_update');
            $table->integer('joueur_id')->unsigned();
            $table->integer('activite_id')->unsigned();
            $table->integer('user_updated_id')->unsigned();
            $table->timestamps();
            $table->foreign('joueur_id')
                ->references('id')
                ->on('joueurs');
            $table->foreign('activite_id')
                ->references('id')
                ->on('activites');
            $table->foreign('user_updated_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->dropForeign('presences_joueur_id_foreign');
            $table->dropForeign('presences_activite_id_foreign');
            $table->dropForeign('presences_user_updated_id_foreign');
        });
        Schema::drop('presences');
    }
}
