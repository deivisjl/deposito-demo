@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-md">
                <div class="card-header">Bienvenido</div>

                <div class="card-body">
                        <table style="width: 100%">
                            <tr class="text-center">
                                <td><i class="fas fa-user-circle fa-3x"></i></td>
                            </tr>
                            <tr class="text-center">
                                <td>{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</td>
                            </tr>
                            <tr class="text-center">
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
