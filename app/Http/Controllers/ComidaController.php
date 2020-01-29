<?php

namespace App\Http\Controllers;
use App\Comida;
use Illuminate\Http\Request;
class ComidaController extends Controller
{
    public function index() {
        $comida=Comida::all();
        return $this->crearRespuesta($alimentos, 200);
    }
    public function store(Request $request) {
        $this->validacion($request);
        Comida::create($request->all());
        return $this->crearRespuesta('El elemento ha sido creado', 201);
    }
    public function show($id) {
        $comida = Comida::find($id);
        if($comida){
            return $this->crearRespuesta($comida, 200);
        }
        return $this->crearRespuestaError('No existe el id', 300);      
    }
    public function update(Request $request, $id) {
        $comida = Comida::find($id);
        if ($clasificacion){
            $this->validacion($request);
            $nombre = $request->get(nombre);
            $nombre = $request->get(nombre);
            $nombre = $request->get(nombre);

            
            $clasificacion->nombre = $nombre;
          

            $clasificacion->save();
            return $this->crearRespuesta('El elemento ha sido modificado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function destroy($id) {
        $comida = Comida::find($id);
        if ($comida){
            $comida->delete();
            return $this->crearRespuesta('El elemento ha sido eliminado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function validacion($request){
        $reglas = [
            'nombre'=>'required'
            
        ];
        $this->validate($request, $reglas);
    }
}
 