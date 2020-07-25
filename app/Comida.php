<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Comida extends Model 
{
    protected $table = 'comidas';

    protected $fillable = [
        'id', 'nombre', 'calorias', 'dieta_id', "notas"
    ];

    
      
    public function dieta()
    {
        return $this->belongsTo('App\Dieta');
    }
    

}
