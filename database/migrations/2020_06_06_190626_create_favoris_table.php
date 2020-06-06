<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->unsigned();
            $table->integer('exercice_id')->unsigned();
            $table->foreign('exercice_id')
				->references('id')
                ->on('exercice')->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('users_id')
                ->references('id')
                ->on('users')->onDelete('restrict')
                ->onUpdate('restrict');
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
        Schema::table('favoris', function (Blueprint $table) {
            $table->dropForeign('favoris_exercice_id_foreign');
			$table->dropForeign('favoris_users_id_foreign');
        });

        Schema::drop('favoris');
    }
}
