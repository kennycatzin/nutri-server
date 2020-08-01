<<<<<<< HEAD
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
=======
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
    
    public function det_comida()
    {
        return $this->hasMany('App\Det_comida');
    }
}
>>>>>>> b029fe68d3f08a7a0b4849c0c74943d5472adb9e
