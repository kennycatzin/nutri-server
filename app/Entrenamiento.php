<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Entramiento extends Model 
{
    protected $table = 'entrenamientos';

    protected $fillable = [
        'sesion_id', 'notas', 'dias'
    ];

    public function clasificacion()
    {
        return $this->hasOne('App\Clasificacion');
    }

}
