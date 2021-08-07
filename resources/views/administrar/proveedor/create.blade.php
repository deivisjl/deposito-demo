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
                                        <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Nueva</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('proveedores.store') }}" method="POST" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for="">Nombre del proveedor</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}">
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">NIT</label>
                                    <input type="text" class="form-control @error('nit') is-invalid @enderror" name="nit" value="{{ old('nit') }}">
                                    @error('nit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Teléfono de contacto</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}">
                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Dirección</label>
                                    <textarea name="direccion" class="form-control @error('minimo') is-invalid @enderror">{{ old('direccion') }}</textarea>
                                    @error('direccion')
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
