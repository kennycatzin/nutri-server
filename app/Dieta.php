<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Det_comida extends Model 
{
    protected $table = 'dietas';

    protected $fillable = [
        'id', 'totcalorias', 'pasiente_id', 'sesion_id', 'notas'
    ];

    
    public function comida()
    {
        return $this->hasMany('App\Det_comida');
    }
}


