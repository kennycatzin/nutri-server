<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Programa extends Model 
{
    protected $table = 'programas';

    protected $fillable = [
        'id', 'nombre', 'notas', 'entrenamiento_id'
    ];

    
    public function det_programa()
    {
        return $this->hasMany('App\Det_programa');
    }
}
