<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Receta extends Model 
{
    protected $table = 'recetas';

    protected $fillable = [
        'id', 'clasificacion_id', 'nombre', 'dificultad',
         'tiempo_coccion', 'tiempo_preparacion', 'total_calorias', 
         'pasos', 'imagen'
    ];

    
    public function alimento()
    {
        return $this->hasMany('App\Alimento');
    }
 
}
