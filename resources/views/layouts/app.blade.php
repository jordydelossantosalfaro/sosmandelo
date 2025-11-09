<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} - @yield('title', 'Panel de Administración')</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('imgs/theme/favicon.svg') }}" />
    <link href="{{ asset('css/main.css?v=1.1') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="/" class="brand-wrap">
                <img src="{{ asset('imgs/theme/logo.svg') }}" class="logo" alt="Nest Dashboard" />
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"><i
                        class="text-muted material-icons md-menu_open"></i></button>
            </div>
        </div>
        <nav>
            <ul class="menu-aside">
                <li class="menu-item{{ request()->routeIs('admin.categories.*') ? ' active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.categories.index') }}">
                        <i class="icon material-icons md-label"></i>
                        <span class="text">
                            Categorías
                        </span>
                    </a>
                </li>
                <li class="menu-item{{ request()->routeIs('admin.subcategories.*') ? ' active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.subcategories.index') }}">
                        <i class="icon material-icons md-view_module"></i>
                        <span class="text">
                            Subcategorías
                        </span>
                    </a>
                </li>
                <li class="menu-item{{ request()->routeIs('admin.brands.*') ? ' active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.brands.index') }}">
                        <i class="icon material-icons md-star"></i>
                        <span class="text">
                            Marcas
                        </span>
                    </a>
                </li>
                <li class="menu-item{{ request()->routeIs('admin.supplier_categories.*') ? ' active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.supplier_categories.index') }}">
                        <i class="icon material-icons md-group_work"></i>
                        <span class="text">
                            Cat. de Proveedores
                        </span>
                    </a>
                </li>
                <li class="menu-item{{ request()->routeIs('admin.suppliers.*') ? ' active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.suppliers.index') }}">
                        <i class="icon material-icons md-business"></i>
                        <span class="text">
                            Proveedores
                        </span>
                    </a>
                </li>
                <li class="menu-item{{ request()->routeIs('admin.products.*') ? ' active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.products.index') }}">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">
                            Productos
                        </span>
                    </a>
                </li>
                <li class="menu-item{{ request()->routeIs('admin.orders.*') ? ' active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.orders.index') }}">
                        <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">
                            Órdenes
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="searchform"></form>
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i
                        class="material-icons md-apps"></i></button>
                <ul class="nav">
                    
                    <li class="nav-item">
                        <a class="nav-link btn-icon darkmode" href="#"> <i
                                class="material-icons md-nights_stay"></i> </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="requestfullscreen nav-link btn-icon"><i
                                class="material-icons md-cast"></i></a>
                    </li>
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" v-pre>
                                <img class="img-xs rounded-circle" src="{{ asset('imgs/people/avatar-2.png') }}"
                                    alt="User" />
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="material-icons md-exit_to_app"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </header>
        <section class="content-main">
            @yield('content')
        </section>
        <!-- content-main end// -->
        <footer class="main-footer font-xs">
            <div class="row pb-30 pt-15">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    &copy; SOS-Mandelo
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end">
                        Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </footer>
    </main>
    <script src="{{ asset('js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('js/vendors/chart.js') }}"></script>
    <script src="{{ asset('js/main.js?v=1.1') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom-chart.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @stack('scripts')
</body>

</html>
