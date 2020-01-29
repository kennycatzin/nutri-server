<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Entramiento extends Model 
{
    protected $table = 'entrenamientos';

    protected $fillable = [
        'name', 'email', 'password'
    ];

    public function clasificacion()
    {
        return $this->hasOne('App\Clasificacion');
    }

}
