<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $table = "producto";

    protected $fillable = [
        'Nombre',
        'Descripsion',
        'Precio',
        'RegStatus'
    ];

    //Relaciones de este modelo

    public function Caracteristicas(){

        return $this -> hasOne(Caracteristica::class, 'IdProducto');

    }

}
