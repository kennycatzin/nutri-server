<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Ejercicio extends Model 
{
    protected $table = 'ejercicios';

    protected $fillable = [
        'id', 'nombre', 'imagen', 'clasificacion_id'
    ];

    public function clasificacion()
    {
        return $this->hasOne('App\Clasificacion');
    }
    
}
