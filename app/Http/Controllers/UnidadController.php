<?php

namespace App\Http\Controllers;
use App\UnidadMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UnidadController extends Controller
{
  public function getElementos(){
      $data = UnidadMedida::orderBy('nombre')->get();
      return $this->crearRespuesta($data, 200);
  }
}
 