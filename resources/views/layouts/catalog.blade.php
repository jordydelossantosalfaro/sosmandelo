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
    <meta property="og:image" content="{{ asset('nest-frontend/assets/imgs/theme/Logofinal_horizontal.png') }}" />

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
            <span>Entregas en 30 minutos en Trujillo</span>
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
                            <img src="{{ asset('nest-frontend/assets/imgs/theme/Logofinal_horizontal.png') }}" alt="logo" />
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
                                                            <h4><span>{{ $details['quantity'] }} × </span>S/. {{ number_format((float)$details['price'], 2) }}</h4>
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
                                                <h4>Total <span>S/. {{ number_format($cartTotal, 2) }}</span></h4>
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
                            <img src="{{ asset('nest-frontend/assets/imgs/theme/Logofinal_horizontal.png') }}" alt="logo" />
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
                                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/aseo.png') }}" alt="" />
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
                                                        <h3><span>{{ $details['quantity'] }} × </span>S/. {{ number_format((float)$details['price'], 2) }}</h3>
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
                                            <h4>Total <span>S/. {{ number_format($mobileCartTotal, 2) }}</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="{{ route('cart.index') }}">Ver carrito</a>
                                            <a href="#">Pagar</a>
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
                        <img src="{{ asset('nest-frontend/assets/imgs/theme/Logofinal_horizontal.png') }}" alt="logo" />
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
                        <a href="mailto:sosmandelo@sosmandelo.com"><i class="fi-rs-email"></i>sosmandelo@sosmandelo.com</a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="https://wa.me/51925996974"><i class="fi-rs-headphones"></i>+51925996974</a>
                    </div>
                </div>
                <div class="mobile-social-icon mb-50">
                    <h6 class="mb-15">Síguenos</h6>
                    <a href="https://web.facebook.com/sosmandelo"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" /></a>
                    <a href="https://www.instagram.com/sosmandelo/"><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" /></a>
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
        <section class="featured section-padding">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                            <div class="banner-icon">
                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-2.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Entrega gratuita</h3>
                                <p>Solo en zonas seleccionadas en el rango de horario 6pm a 9pm.</p>
                            </div>
                        </div>
                    </div>
                    
            
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-xl-none">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
                            <div class="banner-icon">
                                <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-6.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Entrega y pago seguros</h3>
                                <p>Paga al momento de recibir tu pedido</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="newsletter mb-15">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="position-relative newsletter-inner">
                            <div class="newsletter-content">
                                <h2 class="mb-20">
                                    Únete como nuestro socio proveedor o repartidor<br />
                                   
                                </h2>
                                <p class="mb-30">Comienza a generar ganancias con <span class="text-brand">{{ config('app.name') }}</span></p>
                                
                                @if(session('success'))
                                    <div class="alert alert-success mb-3" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; border: 1px solid #c3e6cb;">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                
                                @if(session('error'))
                                    <div class="alert alert-danger mb-3" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; border: 1px solid #f5c6cb;">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form action="{{ route('partner.register') }}" method="POST" class="form-subcriber partner-form" 
                                      style="display: flex; flex-direction: column; gap: 15px; max-width: 500px;" 
                                      onsubmit="return validatePartnerForm(this)">
                                    @csrf
                                    
                                    <div class="form-row" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                        <input type="text" name="nombre_completo" placeholder="Nombre completo *" required 
                                               class="form-input @error('nombre_completo') error @enderror" 
                                               style="flex: 1; min-width: 200px; padding: 12px 20px; border: 1px solid {{ $errors->has('nombre_completo') ? '#dc3545' : '#ddd' }}; border-radius: 8px; font-size: 14px; transition: border-color 0.3s; background: white;" 
                                               value="{{ old('nombre_completo') }}" />
                                        
                                        <div class="whatsapp-input" style="display: flex; align-items: center; background: white; border: 1px solid {{ $errors->has('whatsapp') ? '#dc3545' : '#ddd' }}; border-radius: 8px; padding: 0 10px; transition: border-color 0.3s;">
                                            <span style="color: #666; font-size: 14px; white-space: nowrap; font-weight: 500;">+51</span>
                                            <input type="tel" name="whatsapp" placeholder="925996974 *" required 
                                                   pattern="[0-9]{9}" maxlength="9" 
                                                   class="whatsapp-number @error('whatsapp') error @enderror"
                                                   style="border: none; outline: none; padding: 12px 10px; font-size: 14px; width: 120px; background: transparent;" 
                                                   value="{{ old('whatsapp') }}" 
                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0,9)" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-row" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                        <input type="email" name="email" placeholder="Tu dirección de email *" required 
                                               class="form-input @error('email') error @enderror"
                                               style="flex: 2; min-width: 250px; padding: 12px 20px; border: 1px solid {{ $errors->has('email') ? '#dc3545' : '#ddd' }}; border-radius: 8px; font-size: 14px; transition: border-color 0.3s; background: white;" 
                                               value="{{ old('email') }}" />
                                        
                                        <select name="tipo_socio" required 
                                                class="form-select @error('tipo_socio') error @enderror"
                                                style="flex: 1; min-width: 150px; padding: 12px 15px; border: 1px solid {{ $errors->has('tipo_socio') ? '#dc3545' : '#ddd' }}; border-radius: 8px; font-size: 14px; background: white; transition: border-color 0.3s; cursor: pointer;">
                                            <option value="">Selecciona *</option>
                                            <option value="proveedor" {{ old('tipo_socio') == 'proveedor' ? 'selected' : '' }}>Proveedor</option>
                                            <option value="repartidor" {{ old('tipo_socio') == 'repartidor' ? 'selected' : '' }}>Repartidor</option>
                                        </select>
                                    </div>
                                    
                                    @if($errors->any())
                                        <div class="form-errors" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; border: 1px solid #f5c6cb; font-size: 14px;">
                                            <ul style="margin: 0; padding-left: 20px;">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    <button class="btn partner-submit-btn" type="submit" 
                                            style="align-self: flex-start; padding: 12px 30px; background: #3BB77E; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; position: relative; min-width: 160px;">
                                        <span class="btn-text">Enviar Solicitud</span>
                                        <span class="btn-loading" style="display: none;">
                                            <i class="fi-rs-loading" style="animation: spin 1s linear infinite;"></i> Enviando...
                                        </span>
                                    </button>
                                </form>

                                <style>
                                    .partner-form {
                                        background: transparent !important;
                                    }
                                    
                                    .partner-form .form-input,
                                    .partner-form .form-select,
                                    .partner-form .whatsapp-input {
                                        background: white !important;
                                    }
                                    
                                    .partner-form .form-input:focus, 
                                    .partner-form .form-select:focus, 
                                    .partner-form .whatsapp-input:focus-within {
                                        border-color: #3BB77E !important;
                                        box-shadow: 0 0 0 2px rgba(59, 183, 126, 0.2);
                                        background: white !important;
                                    }
                                    
                                    .partner-form .form-input.error, 
                                    .partner-form .form-select.error,
                                    .partner-form .whatsapp-input:has(.error) {
                                        border-color: #dc3545 !important;
                                        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2);
                                        background: white !important;
                                    }
                                    
                                    .partner-submit-btn:hover {
                                        background: #2a9d62 !important;
                                        transform: translateY(-1px);
                                        box-shadow: 0 4px 12px rgba(59, 183, 126, 0.3);
                                    }
                                    
                                    .partner-submit-btn:disabled {
                                        background: #ccc !important;
                                        cursor: not-allowed !important;
                                        transform: none !important;
                                        box-shadow: none !important;
                                    }
                                    
                                    @keyframes spin {
                                        0% { transform: rotate(0deg); }
                                        100% { transform: rotate(360deg); }
                                    }
                                    
                                    @media (max-width: 576px) {
                                        .partner-form .form-row {
                                            flex-direction: column;
                                        }
                                        .partner-form .whatsapp-input {
                                            max-width: 200px;
                                        }
                                    }
                                </style>

                                <script>
                                    function validatePartnerForm(form) {
                                        const submitBtn = form.querySelector('.partner-submit-btn');
                                        const btnText = submitBtn.querySelector('.btn-text');
                                        const btnLoading = submitBtn.querySelector('.btn-loading');
                                        
                                        // Mostrar estado de carga
                                        submitBtn.disabled = true;
                                        btnText.style.display = 'none';
                                        btnLoading.style.display = 'inline';
                                        
                                        // Validar WhatsApp
                                        const whatsapp = form.whatsapp.value;
                                        if (!/^[0-9]{9}$/.test(whatsapp)) {
                                            alert('El número de WhatsApp debe tener exactamente 9 dígitos.');
                                            resetButton();
                                            return false;
                                        }
                                        
                                        // Validar que el WhatsApp no empiece con 0
                                        if (whatsapp.startsWith('0')) {
                                            alert('El número de WhatsApp no debe empezar con 0.');
                                            resetButton();
                                            return false;
                                        }
                                        
                                        function resetButton() {
                                            submitBtn.disabled = false;
                                            btnText.style.display = 'inline';
                                            btnLoading.style.display = 'none';
                                        }
                                        
                                        return true;
                                    }
                                    
                                    // Auto-formatear WhatsApp mientras se escribe
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const whatsappInput = document.querySelector('input[name="whatsapp"]');
                                        if (whatsappInput) {
                                            whatsappInput.addEventListener('input', function(e) {
                                                // Solo permitir números y limitar a 9 dígitos
                                                this.value = this.value.replace(/[^0-9]/g, '').substring(0, 9);
                                            });
                                        }
                                    });
                                </script>
                            </div>
                            <img src="{{ asset('nest-frontend/assets/imgs/banner/banner-9.png') }}" alt="newsletter" />
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
                             <h4 class="widget-title">Información de Contacto</h4>
                            <ul class="contact-infor">
                                <li><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-contact.svg') }}" alt="" /><strong>Teléfono:</strong><span>+51 987654321</span></li>
                                <li><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-email-2.svg') }}" alt="" /><strong>Email:</strong><span>sosmandelo@sosmandelo.com</span></li>
                                <li><img src="{{ asset('nest-frontend/assets/imgs/theme/icons/icon-clock.svg') }}" alt="" /><strong>Horario:</strong><span>10:00 - 18:00, Lun - Sáb</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Compañía</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">Nosotros</a></li>
                            <li><a href="#">Información de entrega</a></li>
                            <li><a href="#">Política de privacidad</a></li>
                            <li><a href="#">Términos y Condiciones</a></li>
                            <li><a href="#">Contáctanos</a></li>
                            <li><a href="#">Preguntas frecuentes</a></li>
                        </ul>
                    </div>
                   
                    <div class="footer-link-widget col">
                        <h4 class="widget-title">Corporativo</h4>
                        <ul class="footer-list mb-sm-5 mb-md-0">
                            <li><a href="#">Conviértete en proveedor o repartidor</a></li>

                            <li><a href="#">Solicita tu factura aquí</a></li>
                        
                        </ul>
                    </div>
                    
                    <div class="footer-link-widget widget-install-app col text-center">
                        <h4 class="widget-title">Instalar App</h4>
                        <p class="wow fadeIn animated">Desde App Store o Google Play</p>
                        <div class="download-app d-flex justify-content-center flex-wrap gap-2">
                            <a href="#" class="hover-up mb-sm-2 mb-lg-0"><img class="active" src="{{ asset('nest-frontend/assets/imgs/theme/app-store.jpg') }}" alt="" /></a>
                            <a href="#" class="hover-up mb-sm-2"><img src="{{ asset('nest-frontend/assets/imgs/theme/google-play.jpg') }}" alt="" /></a>
                        </div>
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
