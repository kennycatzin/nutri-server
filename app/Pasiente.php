<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Pasiente extends Model 
{
    protected $table = 'pasientes';

    protected $fillable = [
        'id','imagen', 'apellidopaterno', 'correo', 'apellidomaterno', 'nombres', 'fechanacimiento', 'estatura', 'objetivo', 'genero'
    ];

    
  
}
