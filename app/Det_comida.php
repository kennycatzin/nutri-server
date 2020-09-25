<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Det_comida extends Model 
{
    protected $table = 'det_comidas';

    protected $fillable = [
        'id', 'cantidad', 'alimento_id', 'comida_id', 'unidad_id'
    ];

    public function comida()
    {
        return $this->belongsTo('App\Comida');
    }
    public function alimento()
    {
        return $this->hasOne('App\Alimento');
    }
    public function clasificacion()
    {
        return $this->hasOne('App\Clasificacion');
    }
}
