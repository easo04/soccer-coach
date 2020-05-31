<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePratiqueExercice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pratique_exercice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('time', 10);
            $table->string('nbJoueurs');
            $table->string('description', 900);
            $table->string('observations', 900);
            $table->integer('exercice_id')->unsigned();
            $table->integer('pratique_id')->unsigned();
            $table->foreign('exercice_id')
				->references('id')
                ->on('exercice')->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('pratique_id')
                ->references('id')
                ->on('pratique')->onDelete('restrict')
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
        Schema::table('pratique_exercice', function (Blueprint $table) {
            $table->dropForeign('pratique_exercice_exercice_id_foreign');
			$table->dropForeign('pratique_exercice_pratique_id_foreign');
        });

		Schema::drop('pratique_exercice');
    }
}
