<?php

namespace App\Http\Controllers;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RecetaController extends Controller
{
   public function store(Request $request){
        $json = $request->all();
        $alimentos = $json["alimentos"];
        $ultimo=0;
        $this->validacion($request);
        if(!$request->get("id")>0){
            Receta::create($request->all());
            $ultimo=DB::getPdo()->lastInsertId();
        }else{
            $receta = Receta::find($request->get("id"));
            if ($receta){
                $this->validacion($request);
                $nombre = $request->get('nombre');
                $dificultad = $request->get('dificultad');
                $tiempo_coccion = $request->get('tiempo_coccion');
                $tiempo_preparacion = $request->get('tiempo_preparacion');
                $total_calorias = $request->get('total_calorias');
                $pasos = $request->get('pasos');

                $receta->nombre = $nombre;
                $receta->dificultad = $dificultad;
                $receta->tiempo_coccion = $tiempo_coccion;
                $receta->tiempo_preparacion = $tiempo_preparacion;
                $receta->total_calorias = $total_calorias;
                $receta->pasos = $pasos;
                $receta->save();

                $ultimo = $request->get("id");
            }
            
        }
        foreach($alimentos as $alimento){
            if(! $alimento["id"] > 0){
                DB::insert('insert into alimento_receta
                (alimento_id, receta_id, unidad_id, cantidad, calorias)
                 values (?, ?, ?, ?, ?)',
                  [$alimento["alimento_id"], $ultimo, $alimento["unidad_id"], $alimento["cantidad"], $alimento["calorias"]]);
            }else{
                DB::update('update alimento_receta 
                set cantidad = ?, calorias = ?
                 where id = ?', 
                 [$alimento["cantidad"], $alimento["calorias"], $alimento["id"]]);
            }
        }
        return $this->crearRespuesta('El elemento ha sido creado', 201);
   }
   public function deleteDetalle($id_detalle){
        DB::delete('delete from alimento_receta
         where id = ?', [$id_detalle]);
         return $this->crearRespuesta("Elemento eliminado", 200);
   }
   public function deleteReceta($id){
    $receta = Receta::find($id);
        if ($receta){
            $receta->delete();
            DB::delete('delete from alimento_receta
            where receta_id = ?', [$id]);
            return $this->crearRespuesta('El elemento ha sido eliminado', 201);
        }
        return $this->crearRespuestaError('No existe el id', 300);
   }
   public function getRecetasPaginado($valor){
    $desde=0;
    $hasta=6;
    if($valor>0){
        $desde+=$valor;
        $hasta+=$valor;
    }
    $data =  DB::table('recetas')
    ->join('clasificaciones', 'clasificaciones.id', '=', 'recetas.clasificacion_id')
    ->select('recetas.*', 'clasificaciones.nombre AS clasificacion')
    ->skip($desde)
    ->take($hasta)
    ->get();
    return $this->crearRespuesta($data, 200);
   }
   public function getRecetasClasificacion($id_clasificacion, $valor){
    $desde=0;
    $hasta=6;
    if($valor>0){
        $desde+=$valor;
        $hasta+=$valor;
    }
    $data =  DB::table('recetas')
    ->join('clasificaciones', 'clasificaciones.id', '=', 'recetas.clasificacion_id')
    ->select('recetas.*', 'clasificaciones.nombre AS clasificacion')
    ->where('recetas.clasificacion_id', $id_clasificacion)
    ->skip($desde)
    ->take($hasta)
    ->get();
    return $this->crearRespuesta($data, 200);
   }
   public function busqueda(Request $request){
    $valor = $request['busqueda'];
    $query = DB::table('recetas')
    ->join('clasificaciones', 'clasificaciones.id', '=', 'recetas.clasificacion_id')
    ->select('recetas.*', 'clasificaciones.nombre AS clasificacion')
    ->orWhere('recetas.nombre', 'LIKE', '%'.$valor.'%')
    ->take(8)
    ->get();
    return $this->crearRespuesta($query, 200);
   }
   public function getInfoReceta($id_receta){
    $data = DB::table('recetas')
    ->select('id', 'nombre', 'dificultad', 'tiempo_coccion', 'tiempo_preparacion', 'total_calorias', 'pasos')
    ->where('id', $id_receta)
    ->get();

    $alimentos=DB::table('alimento_receta')
    ->join('recetas', 'recetas.id', '=', 'alimento_receta.receta_id')
    ->join('alimentos', 'alimentos.id', '=', 'alimento_receta.alimento_id')
    ->select('alimento_receta.id', 'alimentos.nombre as alimento', 'alimento_receta.cantidad', 'alimento_receta.calorias')
    ->where('alimento_receta.receta_id', $id_receta)
    ->get();

    $data=json_decode(json_encode($data), true);
    $data[0]+=["alimento"=>$alimentos];
    return $this->crearRespuesta($data, 200);

   }
   public function validacion($request){
    $reglas = [
        'nombre'=>'required',
        'clasificacion_id' => 'required',
        'dificultad' => 'required',
        'pasos' => 'required'
    ];
    $this->validate($request, $reglas);
}
}
 