@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row justify-content-center">
              <div class="col-md-12">
                    <div class="card shadow-md">
                        <div class="card-header">
                            <h3 class="card-title-custom">Registrar nueva compra</h3>
                            <div class="card-tools">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb-custom">
                                        <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Nueva</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body">
                            <compra-component></compra-component>
                        </div>
                    </div>
              </div>
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
