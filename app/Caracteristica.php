<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    
    protected $table = "caracteristica";

    protected $fillable = [
        'Nombre',
        'RegStatus'
    ];

    //Relaciones de este modelo

    public function Producto(){

        return $this -> belongsTo(Producto::class, 'IdProducto');

    }

    public function Dominios(){

        return $this -> hasMany(Dominio::class, 'IdCaracteristica');

    }

}
