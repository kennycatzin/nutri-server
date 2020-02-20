<?php

namespace App\Http\Controllers;
use App\Pasiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienteController extends Controller
{
    public function index() {
        $pasiente=Pasiente::all();
        return $this->crearRespuesta($pasiente, 200);
    }
    public function store(Request $request) {
        $this->validacion($request);
        Pasiente::create($request->all());
        return $this->crearRespuesta('El elemento ha sido creado', 201);
    }
    public function show($id) {
        $pasiente = Pasiente::find($id);
        if($pasiente){
            return $this->crearRespuesta($pasiente, 200);
        }
        return $this->crearRespuestaError('No existe el id', 300);      
    }
    public function update(Request $request, $id) {
        $pasiente = Pasiente::find($id);
        if  (!is_null($pasiente)){
            $this->validacion($request);
            $nombres = $request->get('nombres');
            $apellidopaterno = $request->get('apellidopaterno');
            $apellidomaterno = $request->get('apellidomaterno');
            $fechanacimiento = $request->get('fechanacimiento');
            $estatura = $request->get('estatura');
            $objetivo = $request->get('objetivo');
            $genero = $request->get('genero');


            
            $pasiente->nombres = $nombres;
            $pasiente->apellidopaterno = $apellidopaterno;
            $pasiente->apellidomaterno = $apellidomaterno;
            $pasiente->fechanacimiento = $fechanacimiento;
            $pasiente->estatura = $estatura; 
            $pasiente->objetivo = $objetivo;          
            $pasiente->genero = $genero;

            $pasiente->save();
            return $this->crearRespuesta('El elemento ha sido modificado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function destroy($id) {
        $pasiente = Pasiente::find($id);
        if ($pasiente){
            $pasiente->delete();
            return $this->crearRespuesta('El elemento ha sido eliminado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
    }
    public function validacion($request){
        $reglas = [
            'nombres'=>'required',
            'apellidopaterno'=>'required',
            'apellidomaterno'=>'required',
            'fechanacimiento'=>'required',
            'estatura'=>'required',
            'objetivo'=>'required',
            'genero'=>'required'
            
        ];
        $this->validate($request, $reglas);
    }
    public function busqueda($valor){
        $query = Pasiente::orWhere('nombres', 'LIKE', '%'.$valor.'%')
        ->orWhere('apellidopaterno', 'LIKE', '%'.$valor.'%')
        ->orWhere('apellidomaterno', 'LIKE', '%'.$valor.'%')
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
        $query = DB::table('pasientes')->skip($desde)->take($hasta)->get();
        return $this->crearRespuesta($query, 200);

    }
}
 