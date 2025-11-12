@extends('layouts.catalog')

@section('title', $product->name)

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('catalogo.index') }}" class="text-decoration-none">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('catalogo.index', ['categoria' => $product->category_id]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('catalogo.index', ['subcategoria' => $product->subcategory_id]) }}" class="text-decoration-none">{{ $product->subcategory->name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row mb-5">
    <!-- Product Images -->
    <div class="col-md-5 mb-4">
        <div class="mb-3">
            @if($product->images->count() > 0)
                <img id="main-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="img-fluid rounded" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('imgs/no-image.png') }}" class="img-fluid rounded" alt="Sin imagen">
            @endif
        </div>

        @if($product->images->count() > 1)
            <div class="row">
                @foreach($product->images as $image)
                    <div class="col-3 mb-3">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail product-thumbnail"
                            alt="{{ $product->name }}" onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}')">
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Product Details -->
    <div class="col-md-7">
        <h2 class="fw-bold">{{ $product->name }}</h2>

        <div class="mb-3">
            <span class="badge bg-secondary">{{ $product->brand->name }}</span>
            <span class="badge bg-light text-dark">{{ $product->category->name }}</span>
            <span class="badge bg-light text-dark">{{ $product->subcategory->name }}</span>
        </div>

        <div class="mb-3">
            @if($product->promotional_price && $product->promotional_price < $product->price)
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="text-decoration-line-through text-muted fs-5">{{ number_format($product->price, 2) }}</span>
                    <span class="badge bg-danger">
                        -{{ number_format((($product->price - $product->promotional_price) / $product->price) * 100, 0) }}%
                    </span>
                </div>
                <div class="fs-2 fw-bold text-danger">
                    {{ number_format($product->promotional_price, 2) }}
                </div>
            @else
                <div class="fs-2 fw-bold">
                    {{ number_format($product->price, 2) }}
                </div>
            @endif
        </div>

        @if($product->tags->count() > 0)
            <div class="mb-3">
                @foreach($product->tags as $tag)
                    <span class="badge bg-info text-dark">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        <div class="mb-4">
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex gap-3 align-items-center mb-3">
                    <label for="quantity" class="form-label mb-0">Cantidad:</label>
                    <div class="input-group" style="width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="decrementQuantity()">-</button>
                        <input type="number" id="quantity" name="quantity" class="form-control text-center" value="1" min="1">
                        <button class="btn btn-outline-secondary" type="button" onclick="incrementQuantity()">+</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-cart-plus me-2"></i> Agregar al Carrito
                </button>
            </form>
        </div>

        <div class="mb-3">
            <h5>Descripción del producto</h5>
            <div class="border rounded p-3 bg-light">
                @if($product->description)
                    {!! $product->description !!}
                @else
                    <p class="text-muted">No hay descripción disponible para este producto.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
    <div class="section-padding-0 mt-30">
        <div class="container">
            <div class="section-title wow animate__animated animate__fadeIn">
                <h3 class="mb-25">Productos Relacionados</h3>
            </div>
            <div class="carausel-4-columns-cover arrow-center position-relative">
                <div class="slider-arrow slider-arrow-2 carousel-4-columns-arrow" id="carousel-4-columns-arrows"></div>
                <div class="carausel-4-columns carousel-4-columns" id="carausel-4-columns">
                    @foreach($relatedProducts as $related)
                        <div class="product-cart-wrap compact-product">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom compact-img">
                                    <a href="{{ route('catalogo.producto', $related->id) }}">
                                        @if($related->images->count() > 0)
                                            <img class="default-img" src="{{ asset('storage/' . $related->images->first()->image_path) }}" alt="{{ $related->name }}" />
                                        @else
                                            <img class="default-img" src="{{ asset('nest-frontend/assets/imgs/shop/product-placeholder.jpg') }}" alt="Sin imagen" />
                                        @endif
                                    </a>
                                </div>
                                <div class="product-action-1 compact-actions">
                                    <a aria-label="Vista rápida" class="action-btn compact-btn" href="{{ route('catalogo.producto', $related->id) }}">
                                        <i class="fi-rs-eye"></i>
                                    </a>
                                </div>
                                @if($related->promotional_price && $related->promotional_price < $related->price)
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="sale compact-badge">-{{ number_format((($related->price - $related->promotional_price) / $related->price) * 100, 0) }}%</span>
                                    </div>
                                @endif
                            </div>
                            <div class="product-content-wrap compact-content">
                                <div class="product-category compact-category">
                                    <a href="{{ route('catalogo.index', ['categoria' => $related->category_id]) }}">{{ $related->category->name }}</a>
                                </div>
                                <h2 class="compact-title"><a href="{{ route('catalogo.producto', $related->id) }}">{{ $related->name }}</a></h2>
                                <div class="compact-price-section">
                                    @if($related->promotional_price && $related->promotional_price < $related->price)
                                        <span class="font-small text-muted compact-brand">Por <span class="text-brand">{{ $related->brand->name }}</span></span>
                                        <div class="product-price compact-price">
                                            <span class="text-brand">S/. {{ number_format($related->promotional_price, 2) }}</span>
                                            <span class="old-price">S/. {{ number_format($related->price, 2) }}</span>
                                        </div>
                                    @else
                                        <span class="font-small text-muted compact-brand">Por <span class="text-brand">{{ $related->brand->name }}</span></span>
                                        <div class="product-price compact-price">
                                            <span class="text-brand">S/. {{ number_format($related->price, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    function changeMainImage(src) {
        document.getElementById('main-image').src = src;
    }

    function incrementQuantity() {
        const input = document.getElementById('quantity');
        input.value = parseInt(input.value) + 1;
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    // Inicializar carrusel de productos relacionados
    $(document).ready(function() {
        if ($('#carausel-4-columns .product-cart-wrap').length > 0) {
            $('#carausel-4-columns').slick({
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true,
                appendArrows: '#carousel-4-columns-arrows',
                prevArrow: '<span class="slider-btn slider-prev"><i class="fi-rs-angle-left"></i></span>',
                nextArrow: '<span class="slider-btn slider-next"><i class="fi-rs-angle-right"></i></span>',
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            arrows: false,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            arrows: false,
                            dots: true
                        }
                    }
                ]
            });
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Tarjetas compactas */
    .compact-product {
        margin: 0 5px;
        max-width: 180px;
    }
    
    /* Imagen con aspecto natural */
    .compact-img {
        height: 140px;
        overflow: hidden;
        background: #ffffff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .compact-img img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
    }
    
    /* Contenido compacto */
    .compact-content {
        padding: 8px 0;
    }
    
    .compact-category {
        font-size: 11px;
        margin-bottom: 4px;
    }
    
    .compact-title {
        font-size: 13px;
        line-height: 1.3;
        margin-bottom: 6px;
        min-height: 32px;
        overflow: visible;
        word-wrap: break-word;
        hyphens: auto;
    }
    
    .compact-title a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
    }
    
    .compact-brand {
        font-size: 10px;
        margin-bottom: 2px;
        display: block;
    }
    
    .compact-price {
        font-size: 13px;
        font-weight: 600;
    }
    
    /* Acciones compactas */
    .compact-actions {
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .compact-product:hover .compact-actions {
        opacity: 1;
    }
    
    .compact-btn {
        width: 28px;
        height: 28px;
        font-size: 12px;
    }
    
    /* Badge compacto */
    .compact-badge {
        font-size: 10px;
        padding: 2px 6px;
    }
    
    /* Configuración del carrusel */
    .carousel-4-columns .slick-slide {
        margin: 0 5px;
    }
    
    .carousel-4-columns .slick-list {
        margin: 0 -5px;
    }
    
    /* Flechas del carrusel */
    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
    }
    
    .slider-prev {
        left: -30px;
    }
    
    .slider-next {
        right: -30px;
    }
    
    .slider-btn {
        background: #3BB77E;
        color: white;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(59, 183, 126, 0.3);
        font-size: 14px;
    }
    
    .slider-btn:hover {
        background: #2a9d62;
        box-shadow: 0 4px 12px rgba(59, 183, 126, 0.4);
    }
    
    /* Dots para móvil */
    .carousel-4-columns .slick-dots {
        bottom: -30px;
        text-align: center;
    }
    
    .carousel-4-columns .slick-dots li button:before {
        color: #3BB77E;
        font-size: 8px;
    }
    
    /* Responsive específico para móvil */
    @media (max-width: 767px) {
        .compact-product {
            max-width: 150px;
            margin: 0 3px;
        }
        
        .compact-img {
            height: 120px;
        }
        
        .compact-title {
            font-size: 12px;
            min-height: 28px;
        }
        
        .compact-price {
            font-size: 12px;
        }
        
        .slider-prev,
        .slider-next {
            display: none !important;
        }
        
        .section-padding-0.mt-30 {
            margin-top: 20px;
        }
        
        .section-title h3 {
            font-size: 18px;
        }
    }
    
    @media (max-width: 480px) {
        .compact-product {
            max-width: 140px;
        }
        
        .compact-img {
            height: 100px;
        }
        
        .compact-title {
            font-size: 11px;
            min-height: 24px;
        }
        
        .compact-brand {
            font-size: 9px;
        }
        
        .compact-price {
            font-size: 11px;
        }
    }
</style>
@endpush
