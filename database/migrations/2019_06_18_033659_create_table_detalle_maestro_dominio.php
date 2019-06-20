<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetalleMaestroDominio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_maestro_dominio', function (Blueprint $table) {
            $table->integer('IdMaestro')->unsigned();
            $table->integer('IdDominio')->unsigned();
            $table->tinyInteger('RegStatus');
            $table->unique(array('IdMaestro','IdDominio'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_maestro_dominio');
    }
}
