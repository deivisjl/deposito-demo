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
                                        <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Nueva</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('productos.store') }}" method="POST" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}">
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Categoría</label>
                                    <select name="categoria" class="form-control  @error('categoria') is-invalid @enderror">
                                        @foreach ($categorias as $item)
                                            <option value="{{ $item->id }}"
                                                @if( $item->id == old('categoria') )
                                                    selected='selected'
                                                @endif
                                                >{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('categoria')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Porcentaje de ganancia <small>(sin signos)</small></label>
                                    <input type="text" class="form-control @error('porcentaje_ganancia') is-invalid @enderror" name="porcentaje_ganancia" value="{{ old('porcentaje_ganancia') }}">
                                    @error('porcentaje_ganancia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Stock máximo</label>
                                    <input type="text" class="form-control @error('maximo') is-invalid @enderror" name="maximo" value="{{ old('maximo') }}">
                                    @error('maximo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Stock minímo</label>
                                    <input type="text" class="form-control @error('minimo') is-invalid @enderror" name="minimo" value="{{ old('minimo') }}">
                                    @error('minimo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Descripción</label>
                                    <textarea name="descripcion" class="form-control @error('minimo') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                                    @error('minimo')
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
