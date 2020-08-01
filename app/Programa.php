<<<<<<< HEAD
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Programa extends Model 
{
    protected $table = 'programas';

    protected $fillable = [
        'id', 'nombre', 'notas', 'entrenamiento_id'
    ];

    
   
}
=======
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
>>>>>>> b029fe68d3f08a7a0b4849c0c74943d5472adb9e
