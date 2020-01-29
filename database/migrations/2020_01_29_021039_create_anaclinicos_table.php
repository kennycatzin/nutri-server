<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnaclinicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anaclinicos', function (Blueprint $table) {
            $table->increments('id');
            $table->float('colesterol',8,2);
            $table->float('trigliceridos',8,2);
            $table->float('presionarterial',8,2);
            $table->float('pctritmocardiaco',8,2);
            $table->unsignedBigInteger('sesion_id');
            $table->foreign('sesion_id')->references('id')->on('sesiones');
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
        Schema::dropIfExists('anaclinicos');
    }
}
