<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExerciceObjectifs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        Schema::create('exercice_objectifs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exercice_id')->unsigned();
            $table->integer('objectifs_id')->unsigned();
            $table->foreign('exercice_id')
				  ->references('id')
                  ->on('exercice')->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->foreign('objectifs_id')
                ->references('id')
                ->on('objectifs')->onDelete('restrict')
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
        Schema::table('exercice_objectifs', function(Blueprint $table) {
			$table->dropForeign('exercice_objectifs_exercice_id_foreign');
			$table->dropForeign('exercice_objectifs_objectifs_id_foreign');
		});

		Schema::drop('exercice_objectifs');
    }
}
