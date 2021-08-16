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
    Route::resource('proveedores','Administrar\ProveedorController');
    Route::resource('comprobantes','Administrar\ComprobanteController');
    Route::resource('tipo-pago','Administrar\TipoPagoController');

});