<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo')->nullable();
            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')
				->references('id')
                ->on('users')
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
        Schema::table('clubs', function (Blueprint $table) {
			$table->dropForeign('clubs_users_id_foreign');
        });

        Schema::drop('clubs');
    }
}
