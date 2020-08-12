<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note', 400);
            $table->date('date_creation');
            $table->integer('user_creation_id')->unsigned();
            $table->integer('activite_id')->unsigned();
            $table->foreign('activite_id')
                ->references('id')
                ->on('activites');
            $table->foreign('user_creation_id')
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
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign('notes_activite_id_foreign');
            $table->dropForeign('notes_user_creation_id_foreign');
        });
        Schema::drop('notes');
    }
}
