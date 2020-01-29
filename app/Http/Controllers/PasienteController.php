<?php

namespace App\Http\Controllers;
use App\Pasiente;
use Illuminate\Http\Request;
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
        if ($pasiente){
            $this->validacion($request);
            $nombres = $request->get('nombres');
            $apellidopaterno = $request->get('apellidopaterno');
            $apellidomaterno = $request->get('apellidomaterno');
            $fechanacimiento = $request->get('fechanacimiento');
            $estatura = $request->get('estatura');
            $objetivo = $request->get('objetivo');
            $genero = $request->get('genero');


            
            $ejercicio->nombres = $nombres;
            $ejercicio->apellidopaterno = $apellidopaterno;
            $ejercicio->apellidomaterno = $apellidomaterno;
            $ejercicio->fechanacimiento = $fechanacimiento;
            $ejercicio->estatura = $estatura; 
            $ejercicio->objetivo = $objetivo;          
            $ejercicio->genero = $genero;

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
}
 