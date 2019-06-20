<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Caracteristica;
use App\Dominio;
use App\Maestro;

class ProductoController extends Controller
{
    
    public function Listar(){

        $Producto = Producto::where('RegStatus', '=', '1')->get();
        return $Producto;

    }

    public function Buscar($IdProducto){

        $Producto = Producto::find($IdProducto);
        return $Producto; 

    }

    public function Eliminar(Request $Peticion){

        $Json = $Peticion -> input('Json', null);

        $DatosPeticion = json_decode($Json, true);

        $Producto = $this -> Buscar($DatosPeticion['id']);

        $Producto -> RegStatus = 0;

        $Producto -> save();

        $Respuesta = array(
            'status'        =>      'success',
            'code'          =>      '200',
            'message'       =>      'Registro eliminado',
            'producto'      =>      $Producto
        );

        return response() -> json($Respuesta,$Respuesta['code']);

    }

    public function Modificar(Request $Peticion){

        $Json = $Peticion -> input('Json', null);

        $DatosPeticion = json_decode($Json, true);

        $Producto = $this -> Buscar($DatosPeticion['id']);

        $Validacion = \Validator::make($DatosPeticion,[
            'Nombre'        =>      'required|string',
            'Descripsion'   =>      'required|string',
            'Precio'        =>      'required|number'
        ]);

        if($Validacion -> fails()){

            $Respuesta = array(
                'status'        =>      'error',
                'code'          =>      '500',
                'message'       =>      'Error de validacion',
                'errors'        =>      $Validacion -> errors()
            );

        } else {

            $Producto -> Nombre = $DatosPeticion['Nombre'];
            $Producto -> Descripsion = $DatosPeticion['Descripsion'];
            $Producto -> Precio = $DatosPeticion['Precio'];

            $Producto -> RegStatus = 1;

            $Producto -> save();

            $Respuesta = array(
                'status'        =>      'success',
                'code'          =>      '200',
                'message'       =>      'Registro Modificado',
                'producto'      =>      $Producto
            );

        }

        return response() -> json($Respuesta,$Respuesta['code']);

    }

    public function GuardarDetalle(Request $Peticion){

        $Json = $Peticion -> input('Json', null);

        $DatosPeticion = json_decode($Json, true);

        $Validacion = \Validator::make($DatosPeticion,[
            'Nombre'        =>      'required|string',
            'Descripsion'   =>      'required|string',
            'Precio'        =>      'required',
            'NombreTalla'   =>      'required|string'
        ]);

        if($Validacion -> fails()){

            $Respuesta = array(
                'status'        =>      'error',
                'code'          =>      '500',
                'message'       =>      'Error de validacion',
                'errors'        =>      $Validacion -> errors()
            );

        } else {

            //se instancia el objeto producto
            $Producto = new Producto();

            //se asignan los datos de la peticion la objeto
            $Producto -> Nombre = $DatosPeticion['Nombre'];
            $Producto -> Descripsion = $DatosPeticion['Descripsion'];
            $Producto -> Precio = $DatosPeticion['Precio'];
            $Producto -> RegStatus = 1;

            //Se guarda en la base de datos
            $Producto -> save();

            //se instancia le objeto Caracteristica
            $Caracteristica = new Caracteristica();

            //se asignan los datos de la peticion al objeto
            $Caracteristica -> Nombre = $DatosPeticion['NombreTalla'];
            $Caracteristica -> RegStatus = 1;

            //se le asocia el objeto del producto para insertar la llave foranea
            $Caracteristica -> Producto() -> associate($Producto);

            //se guarda en la base de datos
            $Caracteristica -> save();


        }

        return response() -> json($Respuesta,$Respuesta['code']);

    }

    public function Guardardetalles(Request $Peticion){

        $Json = $Peticion -> input('Json', null);

        $DatosPeticion = json_decode($Json, true);

        $Validacion = \Validator::make($DatosPeticion,[
            'Nombre'        =>      'required|string',
            'Descripsion'   =>      'required|string',
            'Precio'        =>      'required',
            'NombreTalla'   =>      'required|string'
        ]);

        if($Validacion -> fails()){

            $Respuesta = array(
                'status'        =>      'error',
                'code'          =>      '500',
                'message'       =>      'Error de validacion',
                'errors'        =>      $Validacion -> errors()
            );

        } else {

            //se instancia el objeto producto
            $Producto = new Producto();

            //se asignan los datos de la peticion la objeto
            $Producto -> Nombre = $DatosPeticion['Nombre'];
            $Producto -> Descripsion = $DatosPeticion['Descripsion'];
            $Producto -> Precio = $DatosPeticion['Precio'];
            $Producto -> RegStatus = 1;

            //Se guarda en la base de datos
            $Producto -> save();

            //se instancia le objeto Caracteristica
            $Caracteristica = new Caracteristica();

            //se asignan los datos de la peticion al objeto
            $Caracteristica -> Nombre = $DatosPeticion['NombreTalla'];
            $Caracteristica -> RegStatus = 1;

            //se le asocia el objeto del producto para insertar la llave foranea
            $Caracteristica -> Producto() -> associate($Producto);

            //se guarda en la base de datos
            $Caracteristica -> save();

            foreach($DatosPeticion['Detalle'] as $DetalleProducto){

                $Dominio = new Dominio();

                $Dominio -> Nombre = $DetalleProducto['talla'];
                $Dominio -> RegStatus = 1;

                $Dominio -> Caracteristica() -> associate($Caracteristica);

                $Dominio -> save();

                $Maestro = new Maestro();

                $Maestro -> Stock = $DetalleProducto['stock'];
                $Maestro -> Precio = $DetalleProducto['precioadicional'];

                $Maestro -> RegStatus = 1;

                $Maestro -> save();

                $Maestro -> Dominios() -> attach($Dominio->id,['RegStatus' => 1]);
            
            }

            //se crear la respuesta
            $Respuesta = array(
                'status'        =>      'success',
                'code'          =>      '200',
                'message'       =>      'Registro guardado',
                'producto'      =>      $Producto
            );

        }
        
        return response()-> json($Respuesta, $Respuesta['code']);

    }

    public function Agregar(Request $Peticion){

        $Json = $Peticion -> input('Json', null);

        $DatosPeticion = json_decode($Json, true);

        $Validacion = \Validator::make($DatosPeticion,[
            'Nombre'        =>      'required|string',
            'Descripsion'   =>      'required|string',
            'Precio'        =>      'required'
        ]);

        if($Validacion -> fails()){

            $Respuesta = array(
                'status'        =>      'error',
                'code'          =>      '500',
                'message'       =>      'Error de validacion',
                'errors'        =>      $Validacion -> errors()
            );

        } else {

            $Producto = new Producto();

            $Producto -> Nombre = $DatosPeticion['Nombre'];
            $Producto -> Descripsion = $DatosPeticion['Descripsion'];
            $Producto -> Precio = $DatosPeticion['Precio'];

            $Producto -> RegStatus = 1;

            $Producto -> save();

            $Respuesta = array(
                'status'        =>      'success',
                'code'          =>      '200',
                'message'       =>      'Registro Guardado',
                'producto'      =>      $Producto
            );

        }

        return response() -> json($Respuesta,$Respuesta['code']);

    }

    public function ListarInventario(){

        $Producto = Producto::with('caracteristicas.dominios.maestros')->where('RegStatus', '=', 1)->get();

        return $Producto;

    }

    public function BuscarInventario($IdProducto){

        $Producto = Producto::with('caracteristicas.dominios.maestros')->find($IdProducto);
        return $Producto;

    }

}
