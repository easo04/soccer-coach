<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 100);
            $table->string('description', 900);
            $table->string('time', 10);
            $table->integer('exercice_id')->unsigned();
            $table->foreign('exercice_id')
				  ->references('id')
                  ->on('exercice');
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
        Schema::dropIfExists('variantes');
    }
}
