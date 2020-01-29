<?php

namespace App\Http\Controllers;
use App\Sesion;
use Illuminate\Http\Request;
class SesionController extends Controller
{
    public function index() {
        $sesion=Sesion::all();
        return $this->crearRespuesta($sesion, 200);
    }
    public function store(Request $request) {
        $this->validacion($request);
        Sesion::create($request->all());
        return $this->crearRespuesta('El elemento ha sido creado', 201);
    }
    public function show() {
        return "desde show";
    }
    public function update() {
        return "desde update";
    }
    public function destroy() {
        return "desde destroy";
    }
}
 