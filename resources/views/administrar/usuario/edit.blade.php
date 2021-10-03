@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row justify-content-center">
              <div class="col-md-8">
                    <div class="card shadow-md">
                        <div class="card-header">
                            <h3 class="card-title-custom">Editar usuario</h3>
                            <div class="card-tools">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb-custom">
                                        <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('usuarios', [$usuario->id]) }}" method="POST" autocomplete="off">
                                <input name="_method" type="hidden" value="PUT">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                            <input type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres" value="{{ $usuario->nombres }}">
                                            @error('nombres')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Apellidos</label>
                                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" value="{{ $usuario->apellidos }}">
                                            @error('apellidos')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">DPI</label>
                                            <input type="text" class="form-control @error('dpi') is-invalid @enderror" name="dpi" value="{{ $usuario->dpi }}">
                                            @error('dpi')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Teléfono</label>
                                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ $usuario->telefono }}">
                                            @error('telefono')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Dirección</label>
                                            <textarea name="direccion" class="form-control @error('direccion') is-invalid @enderror">{{ $usuario->direccion }}</textarea>
                                            @error('direccion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Correo electrónico</label>
                                            <input type="email" class="form-control @error('correo') is-invalid @enderror" name="correo" value="{{ $usuario->email }}">
                                            @error('correo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Rol</label>
                                            <select name="rol" class="form-control @error('rol') is-invalid @enderror">
                                                <option value="0">-- Seleccione una opción --</option>
                                                @foreach($roles as $rol)
                                                <option value="{{ $rol->id }}"
                                                    @if($rol->id == $usuario->rol_id)
                                                        selected='selected'
                                                    @endif>{{ $rol->nombre }}</option>
                                                @endforeach
                                            </select>
                                            @error('rol')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success btn-flat float-right">Editar</button>
                                        </div>
                                    </div>
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
