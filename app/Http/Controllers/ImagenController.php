<?php

namespace App\Http\Controllers;
use App\Receta;
use App\Sesion;
use App\Ejercicio;
use App\Pasiente;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImagenController extends Controller
{
    public function fileUpload(Request $request, $tipo, $id) {
        $modelo = "";
        $indice = "";
        if($tipo == "receta"){
            $indice = "R";
            $modelo = Receta::find($id);
        }
        if($tipo == "paciente"){
            $indice = "P";
            $modelo = Pasiente::find($id);
        }
        $ubi = (object) ['imagen' => ""];
        // $receta = Receta::find($id);
        $response = null;
        $url = (object) ['imagen' => ""];
        if  (!is_null($modelo)){
            if ($request->hasFile('imagen')) {
                $original_filename = $request->file('imagen')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = './upload/'.$tipo.'/';
                $image = $indice.'-' . $id . '.' . $file_ext;
                if ($request->file('imagen')->move($destination_path, $image)) {
                    $ubi->image = './upload/'.$tipo.'/'.$image;
                    $modelo->imagen = $image;
                    $modelo->save();
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

    public function getImagen($tipo, $id){
       $vari = '';
       $data = '';
       $count = 0;
       if($tipo == 'paciente'){
        $data = DB::table('pasientes')
        ->select('imagen')
        ->where('id', $id)
        ->get();
        $count = DB::table('pasientes')
        ->select('imagen')
        ->where('id', $id)
        ->count();
       }
       else if($tipo == 'ejercicio'){

       } else if ($tipo == 'receta'){
        $data = DB::table('recetas')
        ->select('imagen')
        ->where('id', $id)
        ->get();
        $count = DB::table('recetas')
        ->select('imagen')
        ->where('id', $id)
        ->count();
       } else if ($tipo == 'sesion') {

       }
        if($count > 0 and $data[0]->imagen != '' ){
            $vari = env("APP_URL", "localhost").'/upload/'.$tipo.'/'.$data[0]->imagen;
        }else{
            $vari = env("APP_URL", "localhost").'/assets/not-found.png';
        }
        return $this->crearRespuesta($vari, 200);
    }
    
}
 