<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Clasificacion extends Model 
{
    protected $table = 'clasificaciones';

    protected $fillable = [
        'id', 'nombre', 'tipo'
    ];

    public function ejercicios()
    {
        return $this->hasMany('App\Ejercicio');
    }
    public function alimentos()
    {
        return $this->hasMany('App\Alimento');
    }
}
