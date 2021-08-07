@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row justify-content-center">
              <div class="col-md-4">
                    <div class="card shadow-md">
                        <div class="card-header">
                            <h3 class="card-title-custom">Nuevo registro</h3>
                            <div class="card-tools">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb-custom">
                                        <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('comprobantes.index') }}">Comprobantes</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Nueva</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('comprobantes.store') }}" method="POST" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for="">Nombre del comprobante</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}">
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Serie del comprobante</label>
                                    <input type="text" class="form-control @error('serie') is-invalid @enderror" name="serie" value="{{ old('serie') }}">
                                    @error('serie')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Cantidad de números</label>
                                    <input type="text" class="form-control @error('cantidad_numeros') is-invalid @enderror" name="cantidad_numeros" value="{{ old('cantidad_numeros') }}">
                                    @error('cantidad_numeros')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-flat float-right">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
              </div>
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
