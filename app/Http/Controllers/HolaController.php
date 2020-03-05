<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
class HolaController extends Controller
{
   public function index(){

       try {
        $to_name = 'TO_NAME';
        $to_email = 'kenn2506@gmail.com';
        $data = "";
            
        Mail::raw('Text to e-mail', function($message)
        {
            $message->from('roly_alme@hotmail.com', 'Laravel');
        
            $message->to('kenn2506@gmail.com')->cc('kenn2506@gmail.com');
        });
      
           return "se envio";

       } catch (\Throwable $th) {
          echo $th;
       }
       
   }
}
