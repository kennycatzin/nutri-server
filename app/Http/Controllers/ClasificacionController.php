<?php

namespace App\Http\Controllers;
use App\Clasificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClasificacionController extends Controller
{
    public function muscular() {
        $clasificacion=Clasificacion::all()->where('tipo', 'MUSCULAR');
        return  $this->crearRespuesta($clasificacion, 200);
    }
    public function alimentacion() {

        $clasificacion=Clasificacion::where('tipo', 'ALIMENTACION')->get();
        return  $this->crearRespuesta($clasificacion, 200);


        return response()->json(['data' => $clasificacion], 200);
    }
    public function indexOtro() {
        $clasificacion=Clasificacion::all()->where('tipo', 'otro');
        return $this->crearRespuesta($clasificacion, 200);
    }

    public function index() {
        $clasificacion=Clasificacion::all();
        return $this->crearRespuesta($clasificacion, 200);
    }
    public function store(Request $request) {
        $this->validacion($request);
        Clasificacion::create($request->all());
        return $this->crearRespuesta('El elemento ha sido creado', 201);
    }
    public function show($id) {
        $clasificacion = Clasificacion::find($id);
        if($clasificacion){
            return $this->crearRespuesta($alimento, 200);
        }
        return $this->crearRespuestaError('No existe el id', 300);      
    }
    public function update(Request $request, $id) {
        $clasificacion = Clasificacion::find($id);
        if ($clasificacion){
            $this->validacion($request);
            $nombre = $request->get('nombre');
            $tipo = $request->get('tipo');

           
            $clasificacion->nombre = $nombre;
            $clasificacion->tipo = $tipo;
          

            $clasificacion->save();
            return $this->crearRespuesta('El elemento ha sido modificado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function destroy($id) {
        $clasificacion = Clasificacion::find($id);
        if ($clasificacion){
            $clasificacion->delete();
            return $this->crearRespuesta('El elemento ha sido eliminado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function validacion($request){
        $reglas = [
            'nombre'=>'required',
            'tipo'=>'required'
            
        ];
        $this->validate($request, $reglas);
    }
    public function paginacion($valor){
        $desde=0;
        $hasta=6;
        if($valor>0){
            $desde+=$valor;
            $hasta+=$valor;
        }
        $query = DB::table('clasificaciones')->skip($desde)->take($hasta)->get();
        return $this->crearRespuesta($query, 200);
    }
    public function busqueda($valor){
        $query = Clasificacion::orWhere('nombre', 'LIKE', '%'.$valor.'%')->get();
        return $this->crearRespuesta($query, 200);

    }
}
 