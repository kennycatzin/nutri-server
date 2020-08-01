<?php

namespace App\Http\Controllers;
use App\Ejercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EjercicioController extends Controller
{
    public function index() {
        //$ejercicio=Ejercicio::all()->leftJoin('clasificaciones', 'clasificacion.id', '=', 'ejercicios.clasificacion_id');
        $ejercicio = DB::table('ejercicios')
            ->join('clasificaciones', 'clasificaciones.id', '=', 'ejercicios.clasificacion_id')
            ->select('ejercicios.*', 'clasificaciones.nombre AS clasificacion')
            ->get();
        
        return $this->crearRespuesta($ejercicio, 200);
    }
    public function store(Request $request) {
        $this->validacion($request);
        Ejercicio::create($request->all());
        return $this->crearRespuesta('El elemento ha sido creado', 201);
    }
    public function show($id) {
        $ejercicio = Ejercicio::find($id);
        if($ejercicio){
            return $this->crearRespuesta($ejercicio, 200);
        }
        return $this->crearRespuestaError('No existe el id', 300);      
    }
    public function update(Request $request, $id) {
        $ejercicio = Ejercicio::find($id);
        if ($ejercicio){
            $this->validacion($request);
            $nombre = $request->get('nombre');
            $imagen = $request->get('imagen');
            $clasificacion_id = $request->get('clasificacion_id');

            
            $ejercicio->nombre = $nombre;
            $ejercicio->imagen = $imagen;
            $ejercicio->clasificacion_id = $clasificacion_id;
          

            $ejercicio->save();
            return $this->crearRespuesta('El elemento ha sido modificado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function destroy($id) {
        $ejercicio = Ejercicio::find($id);
        if ($ejercicio){
            $ejercicio->delete();
            return $this->crearRespuesta('El elemento ha sido eliminado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function validacion($request){
        $reglas = [
            'nombre'=>'required',
            'clasificacion_id'=>'required'
            
        ];
        $this->validate($request, $reglas);
    }
    public function busqueda($valor){
        $query = $query = DB::table('ejercicios')
        ->join('clasificaciones', 'clasificaciones.id', '=', 'ejercicios.clasificacion_id')
        ->select('ejercicios.*', 'clasificaciones.nombre AS clasificacion')
        ->orWhere('ejercicios.nombre', 'LIKE', '%'.$valor.'%')
        ->get();
        return $this->crearRespuesta($query, 200);

    }
    public function paginacion($valor){
        $desde=0;
        $hasta=6;
        if($valor>0){
            $desde+=$valor;
            $hasta+=$valor;
        }
        $query = DB::table('ejercicios')
        ->join('clasificaciones', 'clasificaciones.id', '=', 'ejercicios.clasificacion_id')
        ->select('ejercicios.*', 'clasificaciones.nombre AS clasificacion')
        ->skip($desde)
        ->take($hasta)
        ->get();
        return $this->crearRespuesta($query, 200);

    }
}

 