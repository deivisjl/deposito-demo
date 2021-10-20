@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-md">
                <div class="card-header">
                    <h5 style="text-align: center!important;font-size: 1.1rem;font-weight: 400;margin: 0;">Reporte gráfico</h5>
                </div>

                <div class="card-body">
                    {{--  --}}
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card shadow-md">
                                <div class="card-header text-center">
                                    <h5 style="text-align: center!important;font-size: 1.1rem;font-weight: 400;margin: 0;">Compras de producto</h5>
                                </div>
                                <div class="card-body">
                                    <grafico-compra-categoria></grafico-compra-categoria>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-md">
                                <div class="card-header">
                                    <h5 style="text-align: center!important;font-size: 1.1rem;font-weight: 400;margin: 0;">Ventas de producto</h5>
                                </div>
                                <div class="card-body">
                                    <grafico-venta-categoria></grafico-venta-categoria>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  --}}
                    <br>
                    {{--  --}}
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card shadow-md">
                                <div class="card-header text-center">
                                    <h5 style="text-align: center!important;font-size: 1.1rem;font-weight: 400;margin: 0;">Inventario de productos</h5>
                                </div>
                                <div class="card-body">
                                    <grafico-existencia-inventario></grafico-existencia-inventario>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-md">
                                <div class="card-header">
                                    <h5 style="text-align: center!important;font-size: 1.1rem;font-weight: 400;margin: 0;">Ventas por mes</h5>
                                </div>
                                <div class="card-body">
                                    <grafico-venta-mes></grafico-venta-mes>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
