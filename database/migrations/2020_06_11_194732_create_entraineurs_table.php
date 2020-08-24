<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntraineursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entraineurs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->integer('equipe_id')->unsigned();
            $table->integer('users_id')->unsigned()->nullable();
            $table->set('role', ['E', 'EA', 'EG', 'G', 'A', 'PP']);
            $table->set('role2', ['E', 'EA', 'EG', 'G', 'A', 'PP']);
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
        Schema::table('entraineurs', function (Blueprint $table) {
            $table->dropForeign('entraineurs_users_id_foreign');
            $table->dropForeign('entraineurs_equipe_id_foreign');
        });

        Schema::drop('entraineurs');
    }
}
