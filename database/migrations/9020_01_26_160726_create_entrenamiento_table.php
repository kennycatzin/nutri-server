<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrenamientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrenamientos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('pasiente_id');
            $table->foreign('pasiente_id')->references('id')->on('pasientes');
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
        Schema::dropIfExists('entrenamientos');
    }
}
