<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} - @yield('title', 'Catálogo de Productos')</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="@yield('description', 'Catálogo de productos SOS-Mandelo')" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="@yield('title', config('app.name'))" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('nest-frontend/assets/imgs/theme/logo.svg') }}" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('nest-frontend/assets/imgs/theme/favicon.svg') }}" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('nest-frontend/assets/css/plugins/slider-range.css') }}" />
    <link rel="stylesheet" href="{{ asset('nest-frontend/assets/css/main.css') }}?v=5.6" />

    @stack('styles')
</head>

<body>
    <!-- Quick view Modal -->
    <div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <!-- MAIN SLIDES -->
                                <div class="product-image-slider">
                                    <figure class="border-radius-10">
                                        <img src="{{ asset('nest-frontend/assets/imgs/shop/product-16-2.jpg') }}" alt="product image" />
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                <span class="stock-status out-stock"> Sale Off </span>
                                <h3 class="title-detail"><a href="#" class="text-heading">Producto Seleccionado</a></h3>
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        <span class="current-price text-brand">$38</span>
                                        <span>
                                            <span class="save-price font-md color3 ml-15">26% Off</span>
                                            <span class="old-price font-md ml-15">$52</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-extralink mb-30">
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <span class="qty-val">1</span>
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Agregar al carrito</button>
                                    </div>
                                </div>
                                <div class="font-xs">
                                    <ul>
                                        <li class="mb-5">Vendor: <span class="text-brand">{{ config('app.name') }}</span></li>
                                        <li class="mb-5">MFG:<span class="text-brand"> {{ date('M d.Y') }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->
    <header class="header-area header-style-1 header-height-2">
        <div class="mobile-promotion">
            <span>Gran apertura, <strong>hasta 15%</strong> de descuento en todos los productos. Solo <strong>3 días</strong> restantes</span>
        </div>
        <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li><a href="{{ route('catalogo.index') }}">Nosotros</a></li>
                                <li><a href="#">Mi Cuenta</a></li>
                                <li><a href="#">Lista de Deseos</a></li>
                                <li><a href="#">Seguimiento de Pedido</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="text-center">
                            <div id="news-flash" class="d-inline-block">
                                <ul>
                                    <li>Entrega 100% segura sin contacto con el repartidor</li>
                                    <li>Ofertas increíbles - Ahorra más con cupones</li>
                                    <li>Descuentos de hasta 35% en productos seleccionados</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info header-info-right">
                            <ul>
                                <li>¿Necesitas ayuda? Llámanos: <strong class="text-brand"> + 1800 900</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ route('catalogo.index') }}">
                            <img src="{{ asset('nest-frontend/assets/imgs/theme/logo.svg') }}" alt="logo" />
                        </a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="{{ route('catalogo.index') }}" method="GET">
                                <select class="select-active" name="categoria">
                                    <option value="">Todas las Categorías</option>
                                    @php
                                        $categories = \App\Models\Category::where('status', 'active')->get();
                                    @endphp
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('categoria') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" name="buscar" placeholder="Buscar productos..." value="{{ request('buscar') }}" />
                            </form>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="header-action-icon-2">
                                    <a href="#">
                                        <img class="svgInject" alt="{{ config('app.name') }}" src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-compare.svg') }}" />
                                        <span class="pro-count blue">3</span>
                                    </a>
                                    <a href="#"><span class="lable ml-0">Comparar</span></a>
                                </div>
                                <div class="header-action-icon-2">
                                    <a href="#">
                                        <img class="svgInject" alt="{{ config('app.name') }}" src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                        <span class="pro-count blue">6</span>
                                    </a>
                                    <a href="#"><span class="lable">Lista de Deseos</span></a>
                                </div>
                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="{{ route('cart.index') }}">
                                        <img alt="{{ config('app.name') }}" src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                        @php
                                            $cart = session('cart', []);
                                            $cartCount = is_array($cart) ? count($cart) : 0;
                                        @endphp
                                        <span class="pro-count blue">{{ $cartCount }}</span>
                                    </a>
                                    <a href="{{ route('cart.index') }}"><span class="lable">Carrito</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        <ul>
                                            @if(session('cart') && is_array(session('cart')) && count(session('cart')) > 0)
                                                @foreach(session('cart') as $id => $details)
                                                    @if(is_array($details) && isset($details['name']) && isset($details['price']) && isset($details['quantity']))
                                                    <li>
                                                        <div class="shopping-cart-img">
                                                            <a href="#"><img alt="{{ config('app.name') }}" src="{{ asset('nest-frontend/assets/imgs/shop/thumbnail-3.jpg') }}" /></a>
                                                        </div>
                                                        <div class="shopping-cart-title">
                                                            <h4><a href="#">{{ $details['name'] }}</a></h4>
                                                            <h4><span>{{ $details['quantity'] }} × </span>${{ number_format((float)$details['price'], 2) }}</h4>
                                                        </div>
                                                        <div class="shopping-cart-delete">
                                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                                        </div>
                                                    </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li>
                                                    <div class="shopping-cart-title">
                                                        <h4>Tu carrito está vacío</h4>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                        <div class="shopping-cart-footer">
                                            <div class="shopping-cart-total">
                                                @php
                                                    $cartTotal = 0;
                                                    $cart = session('cart', []);
                                                    if (is_array($cart) && !empty($cart)) {
                                                        foreach ($cart as $item) {
                                                            if (is_array($item) && isset($item['price']) && isset($item['quantity'])) {
                                                                $cartTotal += (float)$item['price'] * (int)$item['quantity'];
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <h4>Total <span>${{ number_format($cartTotal, 2) }}</span></h4>
                                            </div>
                                            <div class="shopping-cart-button">
                                                <a href="{{ route('cart.index') }}" class="outline">Ver carrito</a>
                                                <a href="#">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-action-icon-2">
                                    <a href="#">
                                        <img class="svgInject" alt="{{ config('app.name') }}" src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-user.svg') }}" />
                                    </a>
                                    <a href="#"><span class="lable ml-0">Cuenta</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                        <ul>
                                            <li><a href="#"><i class="fi fi-rs-user mr-10"></i>Mi Cuenta</a></li>
                                            <li><a href="#"><i class="fi fi-rs-location-alt mr-10"></i>Seguimiento de Pedido</a></li>
                                            <li><a href="#"><i class="fi fi-rs-label mr-10"></i>Mis Cupones</a></li>
                                            <li><a href="#"><i class="fi fi-rs-heart mr-10"></i>Mi Lista de Deseos</a></li>
                                            <li><a href="#"><i class="fi fi-rs-settings-sliders mr-10"></i>Configuración</a></li>
                                            <li><a href="#"><i class="fi fi-rs-sign-out mr-10"></i>Cerrar Sesión</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ route('catalogo.index') }}">
                            <img src="{{ asset('nest-frontend/assets/imgs/theme/logo.svg') }}" alt="logo" />
                        </a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categories-button-active" href="#">
                                <span class="fi-rs-apps"></span> <span class="et">Explorar</span> Todas las Categorías
                                <i class="fi-rs-angle-down"></i>
                            </a>
                            <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                                <div class="d-flex categori-dropdown-inner">
                                    <ul>
                                        @php
                                            $allCategories = \App\Models\Category::where('status', 'active')->take(10)->get();
                                            $halfCount = ceil($allCategories->count() / 2);
                                            $firstHalf = $allCategories->take($halfCount);
                                            $secondHalf = $allCategories->skip($halfCount);
                                        @endphp
                                        @foreach($firstHalf as $category)
                                        <li>
                                            <a href="{{ route('catalogo.index', ['categoria' => $category->id]) }}">
                                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/category-1.svg') }}" alt="" />
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <ul class="end">
                                        @foreach($secondHalf as $category)
                                        <li>
                                            <a href="{{ route('catalogo.index', ['categoria' => $category->id]) }}">
                                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/category-2.svg') }}" alt="" />
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>
                                    <li class="hot-deals"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-hot.svg') }}" alt="hot deals" /><a href="{{ route('catalogo.index') }}">Ofertas</a></li>
                                    <li>
                                        <a class="{{ request()->routeIs('catalogo.index') ? 'active' : '' }}" href="{{ route('catalogo.index') }}">Inicio</a>
                                    </li>
                                    <li>
                                        <a href="#">Nosotros</a>
                                    </li>
                                    <li>
                                        <a href="#">Tienda <i class="fi-rs-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('catalogo.index') }}">Catálogo - Sidebar Derecho</a></li>
                                            <li><a href="#">Lista de Productos</a></li>
                                            <li><a href="#">Comparar Productos</a></li>
                                            <li><a href="{{ route('cart.index') }}">Carrito de Compras</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">Contacto</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-flex">
                        <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-headphone.svg') }}" alt="hotline" />
                        <p>1900 - 888<span>Soporte 24/7</span></p>
                    </div>
                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="#">
                                    <img alt="{{ config('app.name') }}" src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                    <span class="pro-count white">4</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('cart.index') }}">
                                    <img alt="{{ config('app.name') }}" src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count white">{{ $cartCount ?? 0 }}</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        @if(session('cart') && is_array(session('cart')) && count(session('cart')) > 0)
                                            @foreach(session('cart') as $id => $details)
                                                @if(is_array($details) && isset($details['name']) && isset($details['price']) && isset($details['quantity']))
                                                <li>
                                                    <div class="shopping-cart-img">
                                                        <a href="#"><img alt="{{ config('app.name') }}" src="{{ asset('nest-frontend/assets/imgs/shop/thumbnail-3.jpg') }}" /></a>
                                                    </div>
                                                    <div class="shopping-cart-title">
                                                        <h4><a href="#">{{ $details['name'] }}</a></h4>
                                                        <h3><span>{{ $details['quantity'] }} × </span>${{ number_format((float)$details['price'], 2) }}</h3>
                                                    </div>
                                                    <div class="shopping-cart-delete">
                                                        <a href="#"><i class="fi-rs-cross-small"></i></a>
                                                    </div>
                                                </li>
                                                @endif
                                            @endforeach
                                        @else
                                            <li>
                                                <div class="shopping-cart-title">
                                                    <h4>Tu carrito está vacío</h4>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            @php
                                                $mobileCartTotal = 0;
                                                $mobileCart = session('cart', []);
                                                if (is_array($mobileCart) && !empty($mobileCart)) {
                                                    foreach ($mobileCart as $item) {
                                                        if (is_array($item) && isset($item['price']) && isset($item['quantity'])) {
                                                            $mobileCartTotal += (float)$item['price'] * (int)$item['quantity'];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <h4>Total <span>${{ number_format($mobileCartTotal, 2) }}</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="{{ route('cart.index') }}">Ver carrito</a>
                                            <a href="#">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Header -->
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="{{ route('catalogo.index') }}">
                        <img src="{{ asset('nest-frontend/assets/imgs/theme/logo.svg') }}" alt="logo" />
                    </a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="{{ route('catalogo.index') }}" method="GET">
                        <input type="text" name="buscar" placeholder="Buscar productos..." />
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li><a href="{{ route('catalogo.index') }}">Inicio</a></li>
                            <li class="menu-item-has-children">
                                <a href="{{ route('catalogo.index') }}">Tienda</a>
                                <ul class="dropdown">
                                    <li><a href="{{ route('catalogo.index') }}">Catálogo de Productos</a></li>
                                     <li><a href="#">Productos urgentes</a></li>
                                    <li><a href="#">Categorías principales</a></li>
                                   
                                </ul>
                            </li>
                                <li><a href="#">Servicios</a></li>

                             <li class="menu-item-has-children">
                                <a href="#">Soporte Técnico</a>
                                <ul class="dropdown">
                                    
                                     <li><a href="#">Preguntas frecuentes</a></li>
                                    <li><a href="#">Conoce nuestras políticas</a></li>
                                   
                                </ul>
                            </li>
                            <li><a href="#">Nosotros</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="mobile-header-info-wrap">
                    <div class="single-mobile-header-info">
                        <a href="#"><i class="fi-rs-marker"></i> Nuestra ubicación </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#"><i class="fi-rs-user"></i>Iniciar Sesión / Registrarse </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#"><i class="fi-rs-headphones"></i>(+01) - 2345 - 6789 </a>
                    </div>
                </div>
                <div class="mobile-social-icon mb-50">
                    <h6 class="mb-15">Síguenos</h6>
                    <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-twitter-white.svg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-pinterest-white.svg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-youtube-white.svg') }}" alt="" /></a>
                </div>
                <div class="site-copyright">Copyright {{ date('Y') }} © {{ config('app.name') }}. Todos los derechos reservados.</div>
            </div>
        </div>
    </div>
    <!--End header-->

    <!-- Main Content -->
    <main class="main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main">
        <section class="newsletter mb-15">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="position-relative newsletter-inner">
                            <div class="newsletter-content">
                                <h2 class="mb-20">
                                    Quédate en casa y obtén tus <br />
                                    necesidades diarias desde nuestra tienda
                                </h2>
                                <p class="mb-45">Comienza tus compras diarias con <span class="text-brand">{{ config('app.name') }}</span></p>
                                <form class="form-subcriber d-flex">
                                    <input type="email" placeholder="Tu dirección de email" />
                                    <button class="btn" type="submit">Suscribirse</button>
                                </form>
                            </div>
                            <img src="{{ asset('nest-frontend/assets/imgs/banner/banner-9.png') }}" alt="newsletter" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="featured section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-md-4 mb-xl-0">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay="0">
                            <div class="banner-icon">
                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-1.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Mejor precio & ofertas</h3>
                                <p>Pedidos sobre $10</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                            <div class="banner-icon">
                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-2.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Entrega gratuita</h3>
                                <p>Servicio 24/7</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                            <div class="banner-icon">
                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-3.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Ofertas diarias</h3>
                                <p>Al registrarte</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
                            <div class="banner-icon">
                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-4.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Amplio surtido</h3>
                                <p>Mega descuentos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                            <div class="banner-icon">
                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-5.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Devoluciones fáciles</h3>
                                <p>Dentro de 30 días</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-xl-none">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
                            <div class="banner-icon">
                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-6.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Entrega segura</h3>
                                <p>Dentro de 30 días</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding footer-mid">
            <div class="container pt-15 pb-20">
                <div class="row">
                    <div class="col">
                        <div class="widget-about font-md mb-md-3 mb-lg-3 mb-xl-0">
                            <div class="logo mb-30">
                                <a href="{{ route('catalogo.index') }}" class="mb-15">
                                    <img src="{{ asset('nest-frontend/assets/imgs/theme/logo.svg') }}" alt="logo" />
                                </a>
                                <p class="font-lg text-heading">{{ config('app.name') }} - Tu tienda de confianza</p>
                            </div>
                            <ul class="contact-infor">
                                <li><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-location.svg') }}" alt="" /><strong>Dirección: </strong> <span>Tu dirección aquí</span></li>
                                <li><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-contact.svg') }}" alt="" /><strong>Teléfono:</strong><span>(+123) 456-7890</span></li>
                                <li><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-email-2.svg') }}" alt="" /><strong>Email:</strong><span>info@sosmandelo.com</span></li>
                                <li><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-clock.svg') }}" alt="" /><strong>Horario:</strong><span>10:00 - 18:00, Lun - Sáb</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Compañía</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">Nosotros</a></li>
                            <li><a href="#">Información de Entrega</a></li>
                            <li><a href="#">Política de Privacidad</a></li>
                            <li><a href="#">Términos y Condiciones</a></li>
                            <li><a href="#">Contáctanos</a></li>
                            <li><a href="#">Centro de Soporte</a></li>
                            <li><a href="#">Carreras</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Cuenta</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">Iniciar Sesión</a></li>
                            <li><a href="{{ route('cart.index') }}">Ver Carrito</a></li>
                            <li><a href="#">Mi Lista de Deseos</a></li>
                            <li><a href="#">Rastrear Pedido</a></li>
                            <li><a href="#">Ticket de Ayuda</a></li>
                            <li><a href="#">Detalles de Envío</a></li>
                            <li><a href="#">Comparar Productos</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Corporativo</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">Conviértete en Vendedor</a></li>
                            <li><a href="#">Programa de Afiliados</a></li>
                            <li><a href="#">Negocio Agrícola</a></li>
                            <li><a href="#">Carreras Agrícolas</a></li>
                            <li><a href="#">Nuestros Proveedores</a></li>
                            <li><a href="#">Accesibilidad</a></li>
                            <li><a href="#">Promociones</a></li>
                        </ul>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Popular</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            @php
                                $popularCategories = \App\Models\Category::where('status', 'active')->take(7)->get();
                            @endphp
                            @foreach($popularCategories as $category)
                                <li><a href="{{ route('catalogo.index', ['categoria' => $category->id]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="footer-link-widget widget-install-app col">
                        <h4 class="widget-title">Instalar App</h4>
                        <p class="wow fadeIn animated">Desde App Store o Google Play</p>
                        <div class="download-app">
                            <a href="#" class="hover-up mb-sm-2 mb-lg-0"><img class="active" src="{{ asset('nest-frontend/assets/imgs/theme/app-store.jpg') }}" alt="" /></a>
                            <a href="#" class="hover-up mb-sm-2"><img src="{{ asset('nest-frontend/assets/imgs/theme/google-play.jpg') }}" alt="" /></a>
                        </div>
                        <p class="mb-20">Pasarelas de Pago Seguras</p>
                        <img class="wow fadeIn animated" src="{{ asset('nest-frontend/assets/imgs/theme/payment-method.png') }}" alt="" />
                    </div>
                </div>
            </div>
        </section>

        <div class="container pb-30">
            <div class="row align-items-center">
                <div class="col-12 mb-30">
                    <div class="footer-bottom"></div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <p class="font-sm mb-0">&copy; {{ date('Y') }}, <strong class="text-brand">{{ config('app.name') }}</strong> - Plantilla HTML eCommerce<br />Todos los derechos reservados</p>
                </div>
                <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                    <div class="hotline d-lg-inline-flex mr-30">
                        <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/phone-call.svg') }}" alt="hotline" />
                        <p>1900 - 6666<span>Horario 8:00 - 22:00</span></p>
                    </div>
                    <div class="hotline d-lg-inline-flex">
                        <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/phone-call.svg') }}" alt="hotline" />
                        <p>1900 - 8888<span>Centro de Soporte 24/7</span></p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 text-end d-none d-md-block">
                    <div class="mobile-social-icon">
                        <h6>Síguenos</h6>
                        <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-twitter-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-pinterest-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-youtube-white.svg') }}" alt="" /></a>
                    </div>
                    <p class="font-sm">Hasta 15% de descuento en tu primera suscripción</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('nest-frontend/assets/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor JS-->
    <script src="{{ asset('nest-frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/slider-range.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('nest-frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('nest-frontend/assets/js/main.js') }}?v=5.6"></script>
    <script src="{{ asset('nest-frontend/assets/js/shop.js') }}?v=5.6"></script>

    @stack('scripts')
</body>
</html>
