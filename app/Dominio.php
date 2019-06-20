<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dominio extends Model
{

    protected $table = "dominio";

    protected $fillable = [
        'Nombre',
        'RegStatus'
    ];

    //relaciones de este modelo

    public function Caracteristica(){

        return $this -> belongsTo(Caracteristica::class,'IdCaracteristica');

    }

    public function Maestros(){

        return $this -> belongsToMany(Maestro::class,'detalle_maestro_dominio','IdDominio','IdMaestro')->withTimestamps();

    }

}
