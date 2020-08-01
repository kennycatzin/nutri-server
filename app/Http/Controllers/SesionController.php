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
        DB::table('sesiones')->insert(
            ['sesion' => $request->get('sesion'), 
            'imc' => $request->get('imc'),
            'peso'=> $request->get('peso'),
            'pctgrasa'=> $request->get('pctgrasa'),
            'created_at'=> $mytime,
            'updated_at'=> $mytime
            ]
        );
        $sesionId = DB::getPdo()->lastInsertId();
        if($request->get("ana_clinico")){
            $analClinico = $ojso["ana_clinico"];
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
        }
       
        // DIETA
        if($request->get("dieta")){
            $dieta = $ojso["dieta"];
            DB::table('dietas')->insert(
                ['totcalorias' => $dieta["totcalorias"], 
                'pasiente_id'=> 1,
                'notas'=> $dieta["notas"],
                'sesion_id'=> $sesionId,
                'created_at'=> $mytime,
                'updated_at'=> $mytime
                ]
            );
            $dietaId = DB::getPdo()->lastInsertId();
            $comidas = $dieta["comidas"];
            foreach($comidas as $comida){
                 $comida['nombre'];
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
                $detComidas = $comida['det_comidas'];
                foreach($detComidas as $detalleComida){
                    DB::table('det_comidas')->insert(
                        ['cantidad' => $detalleComida['cantidad'], 
                        'clasificacion_id'=> 1,
                        'alimento_id'=> $detalleComida['alimento_id'],
                        'comida_id'=> $comidaId,
                        'created_at'=> $mytime,
                        'updated_at'=> $mytime
                        ]
                    );
                }
            }
        }
       
        // RUTINA
        if($request->get("entrenamiento")){
            $entrenamiento = $ojso["entrenamiento"];
            DB::table('entrenamientos')->insert(
                ['pasiente_id' => 1, 
                'sesion_id'=> $sesionId,
                'notas'=> $entrenamiento['notas'],
                'created_at'=> $mytime,
                'updated_at'=> $mytime
                ]
            );
            $entrenamientoId = DB::getPdo()->lastInsertId();
            $seccionado = $entrenamiento["seccionado"];
            $i=0;
            foreach ($seccionado as $seccion) {
                DB::table('seccionado')->insert(
                    ['entrenamiento_id' => $entrenamientoId, 
                    'dias'=> $seccion['dias'],
                    'notas'=> $seccion['notas']
                    ]
                );
                $seccionadoId = DB::getPdo()->lastInsertId();
                $programas = $seccion['programa'];
                foreach ($programas as $programa) {
                    DB::table('programas')->insert(
                        ['nombre' => $programa["nombre"], 
                        'entrenamiento_id'=> 1,
                        'notas'=> $programa['notas'],
                        'seccionado_id'=> $seccionadoId,
    
                        ]
                    );
                    $programaId = DB::getPdo()->lastInsertId();
                    $detallePrograma = $programas[$i]["det_programa"];
                    foreach ($detallePrograma as $detalle) {
                        DB::table('det_programas')->insert(
                            ['repeticiones' => $detalle["repeticiones"], 
                            'vueltas'=>  $detalle["repeticiones"],
                            'ejercicio_id'=>  $detalle["ejercicio_id"],
                            'programa_id'=> $programaId,
                            'created_at'=> $mytime,
                            'updated_at'=> $mytime
                            ]
                        );
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
            
                $message->to('razonable3500@gmail.com')->cc('razonable3500@gmail.com');
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
 