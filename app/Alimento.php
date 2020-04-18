<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Alimento extends Model 
{
    protected $table = 'alimentos';

    protected $fillable = [
        'id', 'nombre', 'clasificacion_id', 'proteinas', 'grasas', 'carbohidratos'
    ];

    public function clasificaciones()
    {
        
        return $this->belongsTo('App\Clasificacion');
    }
   
}
