@extends('layouts.app')

@section('content')
<div class="row row justify-content-center">
    <div class="col-md-8">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-md">
                    <div class="card-header">
                        <h3 class="card-title-custom">Detalle de compra</h3>
                        <div class="card-tools">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb-custom">
                                    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detalle</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Tipo de pago</th>
                                            <td>{{ $compra->tipo_pago->nombre }}</td>
                                        </tr>
                                        <tr>
                                            <th>Número de comprobante</th>
                                            <td>{{ $compra->no_comprobante }}</td>
                                        </tr>
                                        <tr>
                                            <th>Monto total</th>
                                            <td>Q. {{ $compra->monto }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width:10%; text-align: center">No.</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                            </tr>
                            </thead>
                            @foreach ($compra->detalle_compra as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->producto->nombre }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>Q. {{ $item->precio_unitario }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
</div>
@endsection
