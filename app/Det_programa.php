<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Alimento extends Model 
{
    protected $table = 'det_programas';

    protected $fillable = [
        'id', 'nombre', 'clasificacion_id', 'proteina', 'grasas', 'carbohidratos'
    ];

    public function programa()
    {
        return $this->belongsTo('App\Programa');
    }
    public function ejercicios()
    {
        return $this->hasOne('App\Ejercicio');
    }
}
