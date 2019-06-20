<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//funciones modulo de producto
Route::get('producto/inventario','ProductoController@ListarInventario');
Route::get('producto/inventario/{IdProducto}','ProductoController@BuscarInventario');

Route::get('producto','ProductoController@Listar')->name('ListarProducto');
Route::get('producto/{IdProducto}','ProductoController@Buscar')->name('BuscarProducto');

Route::post('producto','ProductoController@Agregar')->name('AgregarProducto');
Route::post('producto/delete','ProductoController@Eliminar')->name('EliminarProducto');
Route::post('producto/update','ProductoController@Modificar')->name('ModificarProducto');

Route::post('producto/guardardetalles','ProductoController@Guardardetalles');

