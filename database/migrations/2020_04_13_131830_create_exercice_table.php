<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExerciceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('principe', 100);
            $table->string('sousPrincipe', 100);
            $table->string('physique', 100);
            $table->string('time', 10);
            $table->string('nbJoueurs');
            $table->string('url', 100);
            $table->string('image', 100);
            $table->string('description', 900);
            $table->string('observations', 900);
            $table->boolean('private')->default(false);
            $table->integer('typesexcercice_id')->unsigned();
            $table->foreign('typesexcercice_id')
				  ->references('id')
                  ->on('typesexcercice');
            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')
                ->references('id')
                ->on('users');
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
        Schema::table('exercice', function(Blueprint $table) {
            $table->dropForeign('exercice_typesexcercice_id_foreign');
            $table->dropForeign('exercice_users_id_foreign');
		});
        Schema::drop('exercice');
    }
}
