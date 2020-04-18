<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetcomidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_comidas', function (Blueprint $table) {
            $table->increments('id');
            $table->float('cantidad',8,2);
            $table->unsignedBigInteger('clasificacion_id');
            $table->foreign('clasificacion_id')->references('id')->on('clasificaciones');
            $table->unsignedBigInteger('alimento_id');
            $table->foreign('alimento_id')->references('id')->on('alimentos');
            $table->unsignedBigInteger('comida_id');
            $table->foreign('comida_id')->references('id')->on('comidas');
            

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
        Schema::dropIfExists('det_comidas');
    }
}
