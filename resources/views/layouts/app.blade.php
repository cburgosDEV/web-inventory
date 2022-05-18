<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('inlineStyles')
    <script src="{{  asset('js/app.js') }}"></script>
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Inventory App</div>
            </a>
            @role('admin')
                <hr class="sidebar-divider my-0">
                <li class="nav-item">
                    <a id="home" class="nav-link" href="{{ url('/') }}"><i class="fas fa-fw fa-home"></i><span>Inicio</span></a>
                </li>
                <hr class="sidebar-divider">
            @endrole
            <div class="sidebar-heading">
                Principal
            </div>
            <li class="nav-item">
                <a id="sale" class="nav-link" href="{{ url('/sale') }}"><i class="fas fa-fw fa-share-square"></i><span>Realizar una venta</span></a>
            </li>
            <li class="nav-item">
                <a id="purchase" class="nav-link" href="{{ url('/purchase') }}"><i class="fas fa-fw fa-reply-all"></i><span>Realizar una compra</span></a>
            </li>
            <li class="nav-item">
                <a id="expense" class="nav-link" href="{{ url('/expense') }}"><i class="fas fa-fw fa-angle-double-down"></i><span>Gastos</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Administrables
            </div>
            <li class="nav-item">
                <a id="product" class="nav-link" href="{{ url('/product') }}"><i class="fas fa-fw fa-shopping-basket"></i><span>Productos</span></a>
            </li>
            <li class="nav-item">
                <a id="unit" class="nav-link" href="{{ url('/category') }}"><i class="fas fa-fw fa-bars"></i><span>Categorías</span></a>
            </li>
            <li class="nav-item">
                <a id="category" class="nav-link" href="{{ url('/unit') }}"><i class="fas fa-fw fa-pound-sign"></i><span>Unidades</span></a>
            </li>
            <li class="nav-item">
                <a id="customer" class="nav-link" href="{{ url('/customer') }}"><i class="fas fa-fw fa-user-shield"></i><span>Clientes</span></a>
            </li>
            <li class="nav-item">
                <a id="supplier" class="nav-link" href="{{ url('/supplier') }}"><i class="fas fa-fw fa-user-check"></i><span>Proveedores</span></a>
            </li>
            @role('admin')
                <li class="nav-item">
                    <a id="user" class="nav-link" href="{{ url('/user') }}"><i class="fas fa-fw fa-users"></i><span>Usuarios</span></a>
                </li>

            <hr class="sidebar-divider d-none d-md-block">
            <div class="sidebar-heading">
                Reportes
            </div>
            <li class="nav-item">
                <a id="sale" class="nav-link" href="{{ url('/sale') }}"><i class="fas fa-fw fa-share-square"></i><span>Ventas</span></a>
            </li>
            <li class="nav-item">
                <a id="purchase" class="nav-link" href="{{ url('/purchase') }}"><i class="fas fa-fw fa-reply-all"></i><span>Compras</span></a>
            </li>
            <li class="nav-item">
                <a id="expense" class="nav-link" href="{{ url('/expense') }}"><i class="fas fa-fw fa-angle-double-down"></i><span>Gastos</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            @endrole
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                 aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control bg-light border-0 small"
                                               placeholder="Search for..." aria-label="Search"
                                               aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button"><i class="fas fa-search fa-sm"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
                                <img class="img-profile rounded-circle" src="{{asset('storage/'.Auth::user()->avatar)}}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
{{--                                <a class="dropdown-item" href="#">--}}
{{--                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                    Perfil--}}
{{--                                </a>--}}
{{--                                <div class="dropdown-divider"></div>--}}
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Cerrar sesión
                                </a>
                                <form id="logout-form" action="{{ URL('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <input type="hidden" name="baseUrl" id="baseUrl" value="{{ asset('')}}">
                    @yield('content')
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2021</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>
@yield('inlineScript')
</html>
