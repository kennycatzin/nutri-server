<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
class HolaController extends Controller
{
   public function index(){

       try {
        $to_name = 'TO_NAME';
        $to_email = 'razonable3500@gmail.com';
        $data = array('email' => 'kenn2506@gmail.com');
            
        Mail::raw('Text to e-mail', function($message)
        {
            $message->from('roly_alme@hotmail.com', 'Laravel');
        
            $message->to('razonable3500@gmail.com')->cc('razonable3500@gmail.com');
        });
      
           return "se envio";

       } catch (\Throwable $th) {
          echo $th;
       }
       
   }
}
