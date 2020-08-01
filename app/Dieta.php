<<<<<<< HEAD
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Det_comida extends Model 
{
    protected $table = 'dietas';

    protected $fillable = [
        'id', 'totcalorias', 'pasiente_id', 'sesion_id', 'notas'
    ];

    

}


=======
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


>>>>>>> b029fe68d3f08a7a0b4849c0c74943d5472adb9e
