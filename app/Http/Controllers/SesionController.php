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
       // $date = new DateTime();

        //$vari=$json->ana_clinico;
      // Analsis clinico
      $mytime = Carbon::now();
        $analClinico = $ojso["ana_clinico"];
        DB::table('sesiones')->insert(
            ['sesion' => $request->get('sesion'), 
            'imc' => $request->get('imc'),
            'peso'=> $request->get('peso'),
            'pctgrasa'=> $request->get('pctgrasa'),
            'created_at'=> $mytime,
            'updated_at'=> $mytime
            ]
        );
        $id = DB::getPdo()->lastInsertId();
        echo $id;

        // DB::table('anaclinicos')->insert(
        //     ['colesterol' => $analClinico["colesterol"], 
        //     'trigliceridos' => $analClinico["trigliceridos"],
        //     'glucosa'=> $analClinico["glucosa"],
        //     'presionarterial'=> $analClinico["presionarterial"],
        //     'pctritmocardiaco'=> $analClinico["pctritmocardiaco"],
        //     'sesion_id'=> $analClinico["pctritmocardiaco"],
        //     'created_at'=> $date,
        //     'updated_at'=> $date
        //     ]
        // );


        // DIETA
        $dieta = $ojso["dieta"];
        $comidas = $dieta["comidas"];
        $detalleComida = $comidas[1]["det_comidas"];

        // RUTINA
        $entrenamiento = $ojso["entrenamiento"];
        $programa = $entrenamiento["programa"];
        $detallePrograma = $programa[1]["det_programa"];

        
        print_r($detallePrograma);

        //print_r($request);
        // foreach($ojso['articulos'] as $articulo){
        //     $articulo['articulo_id']
        // }
        
    
        // $arreglo1 = $request->get('comidas');
        // print_r($arreglo1);

        return $this->crearRespuesta('El elemento ha sido creado'. $id, 201);
    }
    public function show() {
        return "desde show";
    }
    public function update() {
        return "desde update";
    }
    public function destroy() {
        return "desde destroy";
    }
    public function sendPDFs(){
        $data = [
            'nombre' => 'Jaded Enrique Ruiz Pech',
            'peso' => '74 Kilos'
        ];
        $datos=[];
        $pdf1 = PDF::loadView('vista',compact('data'));
        $pdf2 = PDF::loadView('vista_dos', compact('data'));
        Mail::send('email.credentials', $datos, function($message)
        {
            $message->to('xxxxxx@gmail.com', 'Jon Doe')->subject('Welcome!');
        });
        return "Message Enviado";
    }
}
 