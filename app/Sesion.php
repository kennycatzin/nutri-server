<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Sesion extends Model 
{
    protected $table = 'sesiones';

    protected $fillable = [
        'id', 'sesion', 'imc', 'peso', 'pctgrasa', 'masa_muscular', 
        'metabolismo_basal', 'gasto_calorico_total', 'frecuencia_cardiaca',
        'tipo_cuerpo', 'kg_peso'
    ];

    
    public function dieta()
    {
        return $this->hasMany('App\Dieta');
    }
    public function entrenamiento()
    {
        return $this->hasMany('App\Entrenamiento');
    }
}
