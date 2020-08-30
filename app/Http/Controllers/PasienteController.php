<?php

namespace App\Http\Controllers;
use App\Pasiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use File;

class PasienteController extends Controller
{
    public function fileUpload(Request $request, $id) {
        $pasiente = Pasiente::find($id);
        $response = null;
        $user = (object) ['imagen' => ""];
        if  (!is_null($pasiente)){
            if ($request->hasFile('imagen')) {
                $original_filename = $request->file('imagen')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = './upload/user/';
                $image = 'U-' . $id . '.' . $file_ext;
                if ($request->file('imagen')->move($destination_path, $image)) {
                    $user->image = './upload/user/'.$image;
                    $pasiente->imagen = $image;
                    $pasiente->save();
                return $this->crearRespuesta('La imagen ha sido subida con éxito', 201);
                } else {
                    return $this->crearRespuestaError('Ha ocurrido un error con la imagen', 400);
                }
            } else {
                return $this->crearRespuestaError('No existe el archivo', 400);
            }

        }else{
            return $this->crearRespuestaError('No existe el usuario', 400);
        }
    }
    public function imagenUsuario($id) {
        $path = resource_path() . './upload/user/' . 'U-'.$id. 'png';

        if(!File::exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
    public function index() {
        $pasiente=Pasiente::all();
        return $this->crearRespuesta($pasiente, 200);
    }
    public function store(Request $request) {
        $this->validacion($request);
        Pasiente::create($request->all());
        $ultimo=DB::getPdo()->lastInsertId();
        $this->fileUpload($request, $ultimo);
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
            $correo = $request->get('correo');



            
            $pasiente->nombres = $nombres;
            $pasiente->apellidopaterno = $apellidopaterno;
            $pasiente->apellidomaterno = $apellidomaterno;
            $pasiente->fechanacimiento = $fechanacimiento;
            $pasiente->estatura = $estatura; 
            $pasiente->objetivo = $objetivo;          
            $pasiente->genero = $genero;
            $pasiente->correo = $correo;

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
            'correo'=>'required|unique:pasientes',
            'apellidopaterno'=>'required',
            'apellidomaterno'=>'required',
            'fechanacimiento'=>'required',
            'estatura'=>'required',
            'objetivo'=>'required',
            'genero'=>'required'
            
        ];
        $this->validate($request, $reglas);
    }
    public function busqueda(Request $request){
        $valor = $request['busqueda'];
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
 