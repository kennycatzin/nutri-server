<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AnaClinico extends Model 
{
    protected $table = 'anaclinicos';

    protected $fillable = [
        'id', 'colesterol', 'trigliceridos', 'glucosa', 'presionarterial', 'pctritmocardiaco', 'sesion_id'
    ];

    public function sesion()
    {
        return $this->hasOne('App\Sesion');
    }
   
}
