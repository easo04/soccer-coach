<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('logo')->nullable();
            $table->unsignedInteger('club_id')->nullable();
            $table->integer('users_id')->unsigned();
            $table->timestamps();
            $table->foreign('users_id')
				->references('id')
                ->on('users');
            $table->foreign('club_id')
				->references('id')
                ->on('clubs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipes', function (Blueprint $table) {
            $table->dropForeign('equipes_club_id_foreign');
			$table->dropForeign('equipes_users_id_foreign');
        });

        Schema::drop('equipes');
    }
}
