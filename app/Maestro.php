<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maestro extends Model
{
    
    protected $table = "maestro";

    protected $fillable = [
        'Precio',
        'Stock',
        'RegStatus'
    ];

    //Relaciones de el modelo

    public function Dominios(){

        return $this -> belongsToMany(Dominio::class, 'detalle_maestro_dominio','IdMaestro','IdDominio')->withTimestamps();

    }

}
