<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('apellidopaterno');
            $table->string('apellidomaterno');
            $table->string('nombres');
            $table->date('fechanacimiento');
            $table->date('fecharegistro');
            $table->float('estatura',8,2);
            $table->string('objetivo',8,2);
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
        Schema::dropIfExists('pasientes');
    }
}
