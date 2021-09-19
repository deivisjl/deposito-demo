<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');


Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {

	Route::resource('categorias','Administrar\CategoriaController');

    Route::resource('productos','Administrar\ProductoController');
    Route::get('/buscar-productos-nombre/{criterio}','Administrar\ProductoController@buscarProductoNombre');

    Route::resource('proveedores','Administrar\ProveedorController');
    Route::get('/obtener-proveedores','Administrar\ProveedorController@obtenerProveedores');

    Route::resource('comprobantes','Administrar\ComprobanteController');

    Route::resource('tipo-pago','Administrar\TipoPagoController');
    Route::get('/obtener-tipo-pago','Administrar\TipoPagoController@obtenerTipoPago');

    Route::get('inventario','Inventario\InventarioController@index');
    Route::get('inventario-listar/{request}','Inventario\InventarioController@show');
    Route::get('inventario-detalle/{id}','Inventario\InventarioController@detalle');
    Route::get('inventario-detalle-producto/{request}','Inventario\InventarioController@detalleProducto');

    Route::resource('compras','Compra\CompraController',['only' => ['create','index','store','show']]);

    Route::resource('ventas','Venta\VentaController',['only' => ['create','index','store','show']]);

});
