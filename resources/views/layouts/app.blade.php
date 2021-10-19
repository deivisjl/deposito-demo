<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                        @if(Auth::user()->esDigitador() || Auth::user()->esAdministrador())
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Administrar <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <li><a class="dropdown-item" href="{{ route('categorias.index') }}">Categorías</a></li>
                                    <li><a class="dropdown-item" href="{{ route('productos.index') }}">Productos</a></li>
                                    <li><a class="dropdown-item" href="{{ route('proveedores.index') }}">Proveedores</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('clientes.index') }}">Clientes</a></li>
                                    <li><a class="dropdown-item" href="{{ route('comprobantes.index') }}">Comprobantes</a></li>
                                    <li><a class="dropdown-item" href="{{ route('tipo-pago.index') }}">Tipos de pagos</a></li>
                                    @if(Auth::user()->esAdministrador())
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Usuarios</a></li>
                                    @endif
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->esDigitador() || Auth::user()->esAdministrador())
                        <li class="nav-item">
                            <li><a class="nav-link" href="/compras">Compras</a></li>
                        </li>
                        <li class="nav-item">
                            <li><a class="nav-link" href="/ventas">Ventas</a></li>
                        </li>
                        <li class="nav-item">
                            <li><a class="nav-link" href="/inventario">Inventario</a></li>
                        </li>
                        @if(Auth::user()->esAdministrador())
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Reportes <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <li><a class="dropdown-item" href="/reporte-grafico">Gráfico</a></li>
                                    <li><a class="dropdown-item" href="">Documentos</a></li>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nombres }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/mi-acceso">
                                        Cambiar mi contraseña
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>
</html>
