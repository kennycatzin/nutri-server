<?php

namespace App\Http\Controllers;
use App\Alimento;
use Illuminate\Http\Request;
class AlimentoController extends Controller
{
    public function index() {
        $alimentos=Alimento::all();
        return $this->crearRespuesta($alimentos, 200);
    }
    public function store(Request $request) {
        $this->validacion($request);
        Alimento::create($request->all());
        return $this->crearRespuesta('El alimento ha sido creado', 201);
    }
    public function show($id) {
        $alimento = Alimento::find($id);
        if($alimento){
            return $this->crearRespuesta($alimento, 200);
        }
        return $this->crearRespuestaError('No existe el id', 300);      
    }
    public function update(Request $request, $id) {
        $alimento = Alimento::find($id);
        if ($alimento){
            $this->validacion($request);
            $nombre = $request->get('nombre');
            $proteinas = $request->get('proteinas');
            $grasas = $request->get('grasas');
            $carbohidratos = $request->get('carbohidratos');
            $clasificacion_id = $request->get('clasificacion_id');

            $alimento->nombre = $nombre;
            $alimento->proteinas = $proteinas;
            $alimento->grasas = $grasas;
            $alimento->carbohidratos = $carbohidratos;
            $alimento->clasificacion_id = $clasificacion_id;

            $alimento->save();
            return $this->crearRespuesta('El alimento ha sido modificado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function destroy($id) {
        $alimento = Alimento::find($id);
        if ($alimento){
            $alimento->delete();
            return $this->crearRespuesta('El alimento ha sido eliminado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function validacion($request){
        $reglas = [
            'nombre'=>'required',
            'proteinas'=>'required',
            'grasas'=>'required',
            'carbohidratos'=>'required'
        ];
        $this->validate($request, $reglas);
    }
}
 