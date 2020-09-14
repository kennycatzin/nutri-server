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
    public function fileUpload(Request $request, $id) {
        $ejer = Ejercicio::find($id);
        $response = null;
        $ejercicio = "";
        if  (!is_null($ejer)){
            DB::insert('insert into detalle_imagen_ejercicio
            (descripcion, url, id_ejercicio) values (?, ?, ?)',
             ["descripcion", "", $id]);
             $ultimo=DB::getPdo()->lastInsertId();
            if ($request->hasFile('imagen')) {
                $original_filename = $request->file('imagen')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = './upload/ejercicio/';
                $image = 'E-' . $ultimo . '.' . $file_ext;
                if ($request->file('imagen')->move($destination_path, $image)) {
                    $ejercicio = './upload/ejercicio/'.$image;
                  DB::update('update detalle_imagen_ejercicio
                   set url = ? where id_detalle_imagen_ejercicio = ?',
                    [$ejercicio, $ultimo]);
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
    public function eliminarImagen($id_detalle){
        $imagen = DB::table('detalle_imagen_ejercicio')
        ->select('url')
        ->where('id_detalle_imagen_ejercicio', $id_detalle)
        ->first();
        if(file_exists($imagen->url)) {
            unlink($imagen->url);
            DB::delete('delete from detalle_imagen_ejercicio
             where id_detalle_imagen_ejercicio = ?', [$id_detalle]);
             return $this->crearRespuesta("Elemento eliminado", 200);
        }else{
            return $this->crearRespuestaError("No existe el detalle", 300);
        }
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
            $descripcion = $request->get('descripcion');
            $clasificacion_id = $request->get('clasificacion_id');

            
            $ejercicio->nombre = $nombre;
            $ejercicio->imagen = $imagen;
            $ejercicio->descripcion = $descripcion;
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
    public function busqueda(Request $request){
        $valor = $request['busqueda'];
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
    public function getEjercicioClasificado($clasificacion_id){
        $data = Ejercicio::where('clasificacion_id', $clasificacion_id)->get();
        return $this->crearRespuesta($data, 200);
    }
}

 