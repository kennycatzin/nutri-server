<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Entramiento extends Model 
{
    protected $table = 'entrenamientos';

    protected $fillable = [
        'sesion_id', 'descripcion', 'dias'
    ];

    public function clasificacion()
    {
        return $this->hasOne('App\Clasificacion');
    }

}
