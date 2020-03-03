<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Entramiento extends Model 
{
    protected $table = 'entrenamientos';

    protected $fillable = [
        'pasiente_id', 'sesion_id', 'notas'
    ];

    public function clasificacion()
    {
        return $this->hasOne('App\Clasificacion');
    }

}
