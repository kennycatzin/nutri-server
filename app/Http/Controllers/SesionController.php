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
    public function store(Request $request) {
        try {
        $json = json_encode($request->input());
        $ojso = json_decode($json, true);
      // Analsis clinico
        $mytime = Carbon::now();
        $sesionId = $request->get('id');
        $dietaId = 0;
        if($sesionId === 0){
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
            'notas_dieta'=> $request->get('notas_dieta'),
            'notas_entrenamiento'=> $request->get('notas_entrenamiento'),
            'paciente_id'=> $request->get('paciente_id'),
                ]
            );
            $sesionId = DB::getPdo()->lastInsertId();
        }else{
                DB::update('update sesiones set 
                        imc = ?, peso = ?, updated_at = ?, pctgrasa = ?, masa_muscular = ?, metabolismo_basal = ?,
                        gasto_calorico_total = ?, frecuencia_cardiaca = ?, tipo_cuerpo = ?, notas_dieta = ?,
                        notas_entrenamiento = ?
                        where id = ?', 
                        [$request->get('imc'), $request->get('peso'), $mytime, $request->get('pctgrasa'), $request->get('masa_muscular'), 
                        $request->get('metabolismo_basal'), $request->get('gasto_calorico_total'), $request->get('frecuencia_cardiaca'),
                        $request->get('tipo_cuerpo'), $request->get('notas_dieta'), $request->get('notas_entrenamiento'), $sesionId]);
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
            $dietaId = $dieta["id"];
            if( $dietaId == 0){
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
                            'descripcion'=> $entrenamiento['descripcion'],
                            'created_at'=> $mytime,
                            'updated_at'=> $mytime
                        ]
                    );
                    $entrenamientoId = DB::getPdo()->lastInsertId();
                }else{
                    DB::update('update entrenamientos
                    set dias = ?, descripcion = ?, updated_at = ?
                    where id = ?', 
                    [$entrenamiento['dias'], $entrenamiento['descripcion'], $mytime, $entrenamientoId]);
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
           if($this->sendPDFs($sesionId)) {
                return $this->crearRespuesta('El elemento ha sido creado', 201);
            }
        } catch (\Throwable $th) {
            return $this->crearRespuestaError('Ha ocurrido un error interno'. $th, 500);
        }
    }
    public function consultaDieta($sesionId) {
        $contador = 0;
        $contadorE = 0;
        $contadorD = 0;
        $mytime = Carbon::now();
        setlocale(LC_ALL, 'es_ES');
        $fecha = Carbon::parse($mytime);
        $fecha->format("F"); // Inglés.
        $mes = $fecha->formatLocalized('%B');// mes en idioma español
        $afecha = $mytime->year;

        $data = DB::table('sesiones as ses')
                ->join('pasientes as p', 'p.id', '=', 'ses.paciente_id')
                ->select('ses.id', 'ses.sesion', 'ses.peso', 'ses.notas_dieta', 'ses.pctgrasa',
                'ses.masa_muscular',
                DB::raw('concat(p.nombres, " ", p.apellidopaterno, " ", p.apellidomaterno) as nombre'))
                ->where('ses.id', $sesionId)
                ->get();

        $dieta = DB::table('dietas')
                ->select('id', 'totcalorias', 'notas')
                ->where('sesion_id', $sesionId)
                ->get();

        $comidas = DB::table('comidas')
                ->select('id', 'nombre', 'calorias', 'notas')
                ->where('dieta_id', $dieta[0]->id)
                ->get();
        foreach($comidas as $comida){
            $detComidas = DB::table('det_comidas as dc')
                    ->join('alimentos as al', 'al.id', '=', 'dc.alimento_id')
                    ->join('unidad_medida as um', 'um.id', '=', 'dc.unidad_id')
                    ->select('dc.id', 'dc.cantidad', 'dc.unidad_id', 'um.nombre as unidad', 
                    'dc.alimento_id', 'al.nombre as alimento')
                    ->where('dc.comida_id', $comida->id)
                    ->get();    
                    if($contador == 0){
                        $comidas=json_decode(json_encode($comidas), true);
                    }
        $comidas[$contador]+=["det_comidas"=>$detComidas];
        $contador ++;
        }
        $dieta=json_decode(json_encode($dieta), true);
        $dieta[0]+=["comidas"=>$comidas];
        $data=json_decode(json_encode($data), true);
        $data[0]+=["dieta"=>$dieta[0]];

        $data = $data[0];
        $datos = [
            'nombre' => 'Jaded Enrique Ruiz Pech',
            'peso' => '74 Kilos'
        ];
        $pdf = PDF::loadView('vista', compact('data'));
        return $pdf->download('Dieta-'.$mes.'-'.$afecha.'.pdf');

        //return $this->crearRespuesta( $data, 200);
    }
        public function consultaEntrenamiento($sesionId) {
        $contador = 0;
        $contadorE = 0;
        $contadorD = 0;
        $mytime = Carbon::now();
        setlocale(LC_ALL, 'es_ES');
        $fecha = Carbon::parse($mytime);
        $fecha->format("F"); // Inglés.
        $mes = $fecha->formatLocalized('%B');// mes en idioma español
        $afecha = $mytime->year;

        $data = DB::table('sesiones as ses')
                ->join('pasientes as p', 'p.id', '=', 'ses.paciente_id')
                ->select('ses.id', 'ses.sesion', 'ses.peso', 'ses.notas_entrenamiento', 'ses.pctgrasa',
                'ses.masa_muscular',
                DB::raw('concat(p.nombres, " ", p.apellidopaterno, " ", p.apellidomaterno) as nombre'))
                ->where('ses.id', $sesionId)
                ->get();
            $entrenamientos = DB::table('entrenamientos')
            ->select('id', 'descripcion', 'dias')
            ->where('sesion_id', $sesionId)
            ->get();
            foreach($entrenamientos as $entrenamiento){
                $programas = DB::table('programas')
                ->select('id', 'nombre', 'notas', 'vueltas', 
                'repeticiones', 'descanso')
                ->where('entrenamiento_id', $entrenamiento->id)
                ->get();
                $contadorD = 0;
                foreach($programas as $programa){
                     $detProgramas = DB::table('det_programas as dp')
                    ->join('ejercicios as ej', 'ej.id', '=', 'dp.ejercicio_id')
                    ->join('clasificaciones as cl', 'cl.id', '=', 'ej.clasificacion_id')
                    ->select('dp.programa_id', 'dp.id', 'dp.ejercicio_id', 'cl.nombre as musculo', 
                    'ej.nombre as ejercicio')
                    ->where('dp.programa_id', $programa->id)
                    ->get();
                    if($contadorD == 0){
                        $programas=json_decode(json_encode($programas), true);
                    }
                    $programas[$contadorD]+=["det_programa"=>$detProgramas];
                    $contadorD ++;
                }
                if($contadorE == 0){
                    $entrenamientos=json_decode(json_encode($entrenamientos), true);
                }
                $entrenamientos[$contadorE]+=["programa"=>$programas];
                $contadorE ++;
            }
            $data=json_decode(json_encode($data), true);
            $data[0]+=["entrenamiento"=>$entrenamientos];
            // $data = (object) $data;
            $data = $data[0];
            $datos = [
                'nombre' => 'Jaded Enrique Ruiz Pech',
                'peso' => '74 Kilos'
            ];
             $pdf = PDF::loadView('vista_dos', compact('data'));
             return $pdf->download('Entrenamiento-'.$mes.'-'.$afecha.'.pdf');
             // return $data;    
        }    
        protected function getInfoUsuario($sesionId){
            $data = DB::table('sesiones as ses')
            ->join('pasientes as pa', 'pa.id', '=', 'ses.paciente_id')
            ->select('pa.id', 'pa.correo', 'ses.created_at')
            ->where('ses.id', $sesionId)
            ->first();

            $count = DB::table('sesiones')
            ->select('id')
            ->where('paciente_id', $data->id)
            ->count();
            
            $data=json_decode(json_encode($data), true);
            $data+=["conteo"=>$count];

            $data = (object) $data;

            return $data;
        }
    public function sendPDFs($sesion){
        $infoUsuario = $this->getInfoUsuario($sesion);
        $urlDieta = env("APP_URL", "localhost").'/nutri-server/public/api/sesiones/dieta/'.$sesion ;
        $urlEntrenamiento = env("APP_URL", "localhost").'/nutri-server/public/api/sesiones/entrenamiento/'.$sesion;
        $mytime = Carbon::now();
        setlocale(LC_ALL, 'es_ES');
        $fecha = Carbon::parse($mytime);
        $fecha->format("F"); // Inglés.
        $mes = $fecha->formatLocalized('%B');// mes en idioma español
        $afecha = $mytime->year;
        try {
            $to_name = 'TO_NAME';
            $to_email = 'kenn2506@gmail.com';
            Mail::send('welcome', ['urlDieta' => $urlDieta, 
            'urlEntrenamiento' => $urlEntrenamiento, 'conteo' => $infoUsuario->conteo], 
            function($message) use ($infoUsuario, $mes, $afecha)
            {
                $message->from('roly_alme@hotmail.com', 'ProgramaF&S');
                $message->subject('Programa '. $mes .' '.$afecha);
                $message->to($infoUsuario->correo);
                // $message->attachData($pdf1->output(),'entrenamiento.pdf');
                // $message->attachData($pdf2->output(),'dieta.pdf');
            });
               return "se envio";
           } catch (\Throwable $th) {
              echo $th;
           }
    }
    public function destroy() {
        return "desde destroy";
    }
    public function getSesion($id) {
        $arrComida = [];
        $contador = 0;
        $contadorE = 0;
        $contadorD = 0;
        $data = DB::table('sesiones as ses')
                ->select('id', 'sesion', 'imc', 'peso', 'pctgrasa', 'masa_muscular',
                'metabolismo_basal', 'gasto_calorico_total', 'frecuencia_cardiaca',
                'tipo_cuerpo', 'tipo_cuerpo', 'notas_dieta', 'notas_entrenamiento', 'paciente_id')
                ->where('id', $id)
                ->get();
        $anaClinicos = DB::table('anaclinicos')
                ->select('id', 'colesterol', 'trigliceridos', 'glucosa', 
                'presionarterial', 'pctritmocardiaco')
                ->where('sesion_id', $id)
                ->get();
        $dieta = DB::table('dietas')
                ->select('id', 'totcalorias', 'notas')
                ->where('sesion_id', $id)
                ->get();
        $comidas = DB::table('comidas')
                ->select('id', 'nombre', 'calorias', 'notas')
                ->where('dieta_id', $dieta[0]->id)
                ->get();
        foreach($comidas as $comida){
            $detComidas = DB::table('det_comidas as dc')
                    ->join('alimentos as al', 'al.id', '=', 'dc.alimento_id')
                    ->join('unidad_medida as um', 'um.id', '=', 'dc.unidad_id')
                    ->select('dc.id', 'dc.cantidad', 'dc.unidad_id', 'um.nombre as unidad', 
                    'dc.alimento_id', 'al.nombre as alimento')
                    ->where('dc.comida_id', $comida->id)
                    ->get();    
                    if($contador == 0){
                        $comidas=json_decode(json_encode($comidas), true);
                    }
            $comidas[$contador]+=["det_comidas"=>$detComidas];
            $contador ++;
        } 
        $entrenamientos = DB::table('entrenamientos')
        ->select('id', 'descripcion', 'dias')
        ->where('sesion_id', $id)
        ->get();
        foreach($entrenamientos as $entrenamiento){
            $programas = DB::table('programas')
            ->select('id', 'nombre', 'notas', 'vueltas', 
            'repeticiones', 'descanso')
            ->where('entrenamiento_id', $entrenamiento->id)
            ->get();
            $contadorD = 0;
            foreach($programas as $programa){
                 $detProgramas = DB::table('det_programas as dp')
                ->join('ejercicios as ej', 'ej.id', '=', 'dp.ejercicio_id')
                ->join('clasificaciones as cl', 'cl.id', '=', 'ej.clasificacion_id')
                ->select('dp.programa_id', 'dp.id', 'dp.ejercicio_id', 'cl.nombre as musculo', 
                'ej.nombre as ejercicio')
                ->where('dp.programa_id', $programa->id)
                ->get();
                if($contadorD == 0){
                    $programas=json_decode(json_encode($programas), true);
                }
                $programas[$contadorD]+=["det_programa"=>$detProgramas];
                $contadorD ++;
            }
            if($contadorE == 0){
                $entrenamientos=json_decode(json_encode($entrenamientos), true);
            }
            $entrenamientos[$contadorE]+=["programa"=>$programas];
            $contadorE ++;
        }
        $dieta=json_decode(json_encode($dieta), true);
        $dieta[0]+=["comidas"=>$comidas];
        $data=json_decode(json_encode($data), true);
        $data[0]+=["ana_clinico"=>$anaClinicos[0]];
        $data[0]+=["dieta"=>$dieta[0]];
        $data[0]+=["entrenamiento"=>$entrenamientos];
        return $this->crearRespuesta($data, 200);
    }
}
 