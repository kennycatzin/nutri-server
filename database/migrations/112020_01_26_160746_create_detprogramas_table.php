<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetprogramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_programas', function (Blueprint $table) {
            $table->increments('id');
            $table->float('repeticiones', 8, 2);
            $table->float('vueltas', 8, 2);
            $table->unsignedBigInteger('ejercicio_id');
            $table->foreign('ejercicio_id')->references('id')->on('ejercicios');
            $table->unsignedBigInteger('programa_id');
            $table->foreign('programa_id')->references('id')->on('programas');
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
        Schema::dropIfExists('det_programas');
    }
}
