<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->float('proteinas',8,2);
            $table->float('carbohidratos',8,2);
            $table->float('grasas',8,2);
            $table->unsignedBigInteger('clasificacion_id');
            $table->foreign('clasificacion_id')->references('id')->on('clasificaciones');
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
        Schema::dropIfExists('alimentos');
    }
}
