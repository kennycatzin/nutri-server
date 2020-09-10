<?php

namespace App\Http\Controllers;
use App\Sesion;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

class SesionController extends Controller
{
    public function index() {
        $sesion=Sesion::all();
        return $this->crearRespuesta($sesion, 200);
    }
    public function store(Request $request, $id) {
        $json = json_encode($request->input());
        $ojso = json_decode($json, true);
      // Analsis clinico
        $mytime = Carbon::now();
        $sesionId = $request->get('id');
        $dietaId = 0;
        if($sesionId == 0){
            DB::table('sesiones')->insert(
                ['sesion' => $request->get('sesion'), 
            'imc' => $request->get('imc'),
            'peso'=> $request->get('peso'),
            'pctgrasa'=> $request->get('pctgrasa'),
            'created_at'=> $mytime,
            'updated_at'=> $mytime,
            'masa_muscular' => $request->get('masa_muscular'), 
            'metabolismo_basal' => $request->get('metabolismo_basal'),
            'gasto_calorico_total'=> $request->get('gasto_calorico_total'),
            'frecuencia_cardiaca'=> $request->get('frecuencia_cardiaca'),
            'tipo_cuerpo'=> $request->get('tipo_cuerpo'),
                'paciente_id'=> $request->get('paciente_id'),
                ]
            );
            $sesionId = DB::getPdo()->lastInsertId();
        }else{
                DB::update('update sesiones set 
                        imc = ?, peso = ?, updated_at = ?, pctgrasa = ?, masa_muscular = ?, metabolismo_basal = ?,
                        gasto_calorico_total = ?, frecuencia_cardiaca = ?, tipo_cuerpo = ?
                        where id = ?', 
                        [$sesionId, $request->get('imc'), $mytime, $request->get('pctgrasa'), $request->get('masa_muscular'), 
                        $request->get('metabolismo_basal'), $request->get('gasto_calorico_total'), $request->get('frecuencia_cardiaca'),
                        $request->get('tipo_cuerpo'), $sesionId]);
        }
        if($request->get("ana_clinico")){
            $analClinico = $ojso["ana_clinico"];
            $anaClinicoID = $analClinico["id"];
            if($anaClinicoID == 0){
                DB::table('anaclinicos')->insert(
                    ['colesterol' => $analClinico["colesterol"], 
                    'trigliceridos' => $analClinico["trigliceridos"],
                    'glucosa'=> $analClinico["glucosa"],
                    'presionarterial'=> $analClinico["presionarterial"],
                    'pctritmocardiaco'=> $analClinico["pctritmocardiaco"],
                    'sesion_id'=> $sesionId,
                    'created_at'=> $mytime,
                    'updated_at'=> $mytime
                    ]
                );
            }else{
                DB::update('update anaclinicos set 
                colesterol = ?, trigliceridos = ?, glucosa = ?,
                presionarterial = ?, pctritmocardiaco = ?, updated_at = ? 
                where id = ?', 
                [$analClinico["colesterol"], $analClinico["trigliceridos"], $analClinico["glucosa"],
                $analClinico["presionarterial"], $analClinico["pctritmocardiaco"], $mytime, $anaClinicoID]);
            }
            
        }
        // DIETA
        if($request->get("dieta")){
            $dieta = $ojso["dieta"];
            $dietaID = $dieta["id"];
            if( $dietaID == 0){
                DB::table('dietas')->insert(
                    ['totcalorias' => $dieta["totcalorias"], 
                    'notas'=> $dieta["notas"],
                    'sesion_id'=> $sesionId,
                    'created_at'=> $mytime,
                    'updated_at'=> $mytime
                    ]
                );
                $dietaId = DB::getPdo()->lastInsertId();
            }else {
                DB::update('update dietas set 
                totcalorias = ?, notas = ?, updated_at = ? 
                where id = ?', 
                [$dieta["totcalorias"], $dieta["notas"], $mytime, $dietaId]);
            }
            $comidas = $dieta["comidas"];
            foreach($comidas as $comida){
                 $comida['nombre'];
                 $comidaId = $comida['id'];
                 if( $comidaId == 0){
                    DB::table('comidas')->insert(
                        ['nombre' => $comida['nombre'], 
                        'calorias'=> $comida['calorias'],
                        'dieta_id'=> $dietaId,
                        'notas'=> $comida['notas'],
                        'created_at'=> $mytime,
                        'updated_at'=> $mytime
                        ]
                    );
                    $comidaId = DB::getPdo()->lastInsertId();
                 }else{
                     DB::update('update comidas set 
                     nombre = ?, calorias = ?, notas = ?, updated_at = ?
                     where id = ?', 
                     [$comida['nombre'], $comida['calorias'], $comida['notas'], $mytime, $comidaId]);
                 }
                 
                $detComidas = $comida['det_comidas'];
                foreach($detComidas as $detalleComida){
                    $detComidaID = $detalleComida['id'];
                    if( $detComidaID == 0){
                        DB::table('det_comidas')->insert(
                            ['cantidad' => $detalleComida['cantidad'], 
                            'unidad_id'=> $detalleComida['unidad_id'],
                            'alimento_id'=> $detalleComida['alimento_id'],
                            'comida_id'=> $comidaId,
                            'created_at'=> $mytime,
                            'updated_at'=> $mytime
                            ]
                        );
                    }else{
                        DB::update('update det_comidas set 
                        cantidad = ?, unidad_id = ?,  updated_at = ? 
                        where id = ?', 
                        [$detalleComida['cantidad'], $detalleComida['unidad_id'], $mytime, $detComidaID]);
                    } 
                }
            }
        }
       
        // Entrenamiento
        if($request->get("entrenamiento")){
            $entrenamientos = $ojso["entrenamiento"];
            foreach ($entrenamientos as $entrenamiento) {
                $entrenamientoId = $entrenamiento['id'];
                if( $entrenamientoId == 0){
                    DB::table('entrenamientos')->insert(
                        [
                            'sesion_id' => $sesionId,
                            'dias' => $entrenamiento['dias'],
                            'notas'=> $entrenamiento['notas'],
                            'created_at'=> $mytime,
                            'updated_at'=> $mytime
                        ]
                    );
                    $entrenamientoId = DB::getPdo()->lastInsertId();
                }else{
                    DB::update('update entrenamientos
                    set dias = ?, notas = ?, updated_at = ?
                    where id = ?', 
                    [$entrenamiento['dias'], $entrenamiento['notas'], $mytime, $entrenamientoId]);
                }
            $i=0;
            $programas = $entrenamiento['programa'];
                foreach ($programas as $programa) {
                    $programaId = $programa["id"];
                    if($programaId == 0){
                        DB::table('programas')->insert(
                            [
                                'nombre' => $programa["nombre"], 
                                'entrenamiento_id'=> $entrenamientoId,
                                'repeticiones'=> $programa["repeticiones"],
                                'vueltas'=> $programa["vueltas"],
                                'descanso'=> $programa["descanso"],
                                'notas'=> $programa['notas']
                            ]
                        );
                        $programaId = DB::getPdo()->lastInsertId();
                    }else{
                        DB::update('update programas set 
                        nombre = ?, repeticiones = ?, vueltas = ?, descanso = ?, notas = ?
                        where id = ?', 
                        [$programa["nombre"], $programa["repeticiones"], $programa["vueltas"], $programa["descanso"], 
                        $programa['notas'], $programaId]);
                    }
                    $detallePrograma = $programas[$i]["det_programa"];
                    // $detallePrograma = $programas["det_programa"];
                    foreach ($detallePrograma as $detalle) {
                        $idDetalle = $detalle["id"];
                        if( $idDetalle == 0){
                            DB::table('det_programas')->insert(
                                [
                                    'ejercicio_id'=>  $detalle["ejercicio_id"],
                                    'programa_id'=> $programaId,
                                    'created_at'=> $mytime,
                                    'updated_at'=> $mytime
                                ]
                            );
                        }else{
                            DB::update('update det_programas set updated_at = ?
                             where id = ?', 
                             [$mytime, $idDetalle]);
                        }
                    }
                    $i++;  
                }
                $i=0;
            }
        }
       
        return $this->crearRespuesta('El elemento ha sido creado'. $id, 201);
    }
    public function consultaDieta($sesionId) {
        $query = DB::table('sesiones')
            ->join('dietas', 'dietas.sesion_id', '=', 'sesiones.id')
            ->join('comidas', 'comidas.dieta_id', '=', 'dietas.id')
            ->join('det_comidas', 'det_comidas.comida_id', '=', 'comidas.id')
            ->join('alimentos', 'det_comidas.alimento_id', '=', 'alimentos.id')
            ->select('sesiones.*', 'dietas.*', 'comidas.nombre','det_comidas.cantidad', 'alimentos.nombre')
            ->where('sesiones.id', $sesionId)
            ->get();
        return $this->crearRespuesta( $query, 200);
    }
        public function consultaEntrenamiento($sesionId) {
            echo $sesionId;
            $query = DB::table('sesiones')
                ->join('entrenamientos', 'sesiones.id', '=', 'entrenamientos.sesion_id')
                ->join('seccionado', 'seccionado.entrenamiento_id', '=', 'entrenamientos.id')
                ->join('programas', 'programas.seccionado_id', '=', 'seccionado.id')
                ->join('det_programas', 'det_programas.programa_id', '=', 'programas.id')
                ->join('ejercicios', 'ejercicios.id', '=', 'det_programas.ejercicio_id')
                ->select('sesiones.*', 'seccionado.*', 'programas.*','det_programas.*', 'ejercicios.nombre')
                ->where('sesiones.id', $sesionId)
                ->get();
    
    
            return $this->crearRespuesta( $query, 200);
            }    
    public function sendPDFs(){
        $data = [
            'nombre' => 'Jaded Enrique Ruiz Pech',
            'peso' => '74 Kilos'
        ];
        $datos=[];
        $pdf1 = PDF::loadView('vista',compact('data'));
        $pdf2 = PDF::loadView('vista_dos', compact('data'));
        
        try {
            $to_name = 'TO_NAME';
            $to_email = 'razonable3500@gmail.com';
            $data = array('email' => 'kenn2506@gmail.com');
                
            Mail::send('welcome',$data, function($message) use ($pdf1, $pdf2)
            {
                $message->from('roly_alme@hotmail.com', 'Laravel');
            
                $message->to('kenn2506@gmail.com')->cc('kenn2506@gmail.com');
                $message->attachData($pdf1->output(),'entrenamiento.pdf');
                $message->attachData($pdf2->output(),'dieta.pdf');
            });
          
               return "se envio";
    
           } catch (\Throwable $th) {
              echo $th;
           }
    }
    public function destroy() {
        return "desde destroy";
    }
}
 