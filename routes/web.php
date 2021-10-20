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

Route::group(['middleware' => ['auth','admin']], function() {

    Route::resource('usuarios','Administrar\UsuarioController');

    Route::get('reporte-grafico','Reportes\ReporteGraficoController@index');
    Route::post('compras-por-categoria','Reportes\ReporteGraficoController@ComprasPorCategoria');
    Route::post('categorias-mas-vendidas','Reportes\ReporteGraficoController@GraficoVentaCategoria');
    Route::post('existencias-en-inventario','Reportes\ReporteGraficoController@ExistenciaEnInventario');
    Route::post('ventas-por-mes','Reportes\ReporteGraficoController@VentaPorMes');

    Route::get('reporte-documento','Reportes\ReporteDocumentoController@index');
    Route::post('reporte-documento-compra','Reportes\ReporteDocumentoController@ReporteDocumentoCompra');
    Route::post('reporte-documento-venta','Reportes\ReporteDocumentoController@ReporteDocumentoVenta');
    Route::post('reporte-documento-inventario','Reportes\ReporteDocumentoController@ReporteDocumentoInventario');
    Route::post('reporte-documento-venta-mes','Reportes\ReporteDocumentoController@ReporteDocumentoVentaMes');
});

Route::group(['middleware' => ['auth','digitador']], function() {

    Route::get('mi-acceso','Administrar\UsuarioController@miAcceso');
    Route::post('mi-acceso-actualizar','Administrar\UsuarioController@miAccesoActualizar');

	Route::resource('categorias','Administrar\CategoriaController');

    Route::resource('clientes','Administrar\ClienteController');
    Route::get('/obtener-clientes','Administrar\ClienteController@obtenerClientes');
    Route::post('/guardar-nuevo-cliente','Administrar\ClienteController@guardarNuevoCliente');

    Route::resource('productos','Administrar\ProductoController');
    Route::get('/buscar-productos-nombre/{criterio}','Administrar\ProductoController@buscarProductoNombre');

    Route::resource('proveedores','Administrar\ProveedorController');
    Route::get('/obtener-proveedores','Administrar\ProveedorController@obtenerProveedores');

    Route::resource('comprobantes','Administrar\ComprobanteController');
    Route::get('/obtener-tipo-comprobante','Administrar\ComprobanteController@obtenerTipoComprobante');

    Route::resource('tipo-pago','Administrar\TipoPagoController');
    Route::get('/obtener-tipo-pago','Administrar\TipoPagoController@obtenerTipoPago');

    Route::get('inventario','Inventario\InventarioController@index');
    Route::get('inventario-listar/{request}','Inventario\InventarioController@show');
    Route::get('inventario-detalle/{id}','Inventario\InventarioController@detalle');
    Route::get('inventario-detalle-producto/{request}','Inventario\InventarioController@detalleProducto');

    Route::resource('compras','Compra\CompraController',['only' => ['create','index','store','show']]);
    Route::get('compras/{id}/detalle','Compra\CompraController@detalle');

    Route::resource('ventas','Venta\VentaController',['only' => ['create','index','store','show']]);
    Route::get('ventas/{id}/detalle','Venta\VentaController@detalle');
});
