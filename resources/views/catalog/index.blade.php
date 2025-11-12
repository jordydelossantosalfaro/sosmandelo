@extends('layouts.catalog')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="container mb-30">
    <div class="row">
        <div class="col-12">
            <section class="product-tabs section-padding position-relative">
                <!-- Categorías movidas arriba del título -->
                <section class="popular-categories pt-0 pb-1">
                    <div class="container-fluid px-0 wow animate__animated animate__fadeIn">
                        <div class="section-title"> 
                            <div class="title">
                                <h3 class="mb-2" style="margin-top:0;font-size:1.1rem;">
                                    Nuestras categorías 
                                    <i class="fi-rs-angle-double-right" style="color:#28a745; font-size:1rem; animation: slideHint 1.5s ease-in-out infinite;"></i>
                                </h3>
                                <a class="show-all" href="{{ route('catalogo.index') }}">
                                    Todas las categorías
                                    <i class="fi-rs-angle-right"></i>
                                </a>
                            </div>
                            <style>
                                @keyframes slideHint {
                                    0%, 100% { transform: translateX(0); opacity: 0.7; }
                                    50% { transform: translateX(5px); opacity: 1; }
                                }
                            </style>
                            <div class="slider-arrow slider-arrow-2 flex-right carausel-8-columns-arrow" id="carausel-8-columns-arrows">
                                <button type="button" class="slider-btn slider-prev btn btn-light btn-sm opacity-75" aria-label="Ver categorías anteriores" title="Anterior">
                                    <i class="fi-rs-angle-left"></i>
                                </button>
                                <button type="button" class="slider-btn slider-next btn btn-light btn-sm opacity-75 ms-2" aria-label="Ver más categorías" title="Siguiente">
                                    <i class="fi-rs-angle-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="carausel-8-columns-cover position-relative">
                            <div class="" id="carausel-8-columns" style="display:flex; gap:12px; overflow-x:auto; scroll-behavior:smooth; white-space:nowrap; scrollbar-width:none; -ms-overflow-style:none;">
                                @foreach($categories as $index => $category)
                                <div class="" style="width:110px; height:110px; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:10px; border:2px solid #28a745; border-radius:12px;">
                                    <figure class="img-hover-scale overflow-hidden" style="margin:0; height:65px; display:flex; align-items:center; justify-content:center;">
                                        <a href="{{ route('catalogo.index', ['categoria' => $category->id]) }}">
                                            @php
                                                $categoryNum = $index + 1;  // Sin módulo 10 para permitir más de 10 categorías
                                                $customIcons = [
                                                    1 => 'aseo.png',
                                                    2 => 'audio.png',
                                                    3 => 'belleza.png',
                                                    4 => 'calzados.png',
                                                    5 => 'deporte.png',
                                                    6 => 'electronica.png',
                                                    7 => 'ferreteria.png',
                                                    8 => 'iluminacion.png',
                                                    9 => 'jardin.png',
                                                    10 => 'juguete.png',
                                                    11 => 'libreria.png',
                                                    12 => 'mascotas.png',
                                                    13 => 'menaje.png',
                                                    14 => 'pinturas.png',
                                                    15 => 'redes.png',
                                                    16 => 'ropa.png',
                                                    17 => 'supermercado.png',
                                                    18 => 'tecnologia.png'
                                                ];
                                                
                                                if (isset($customIcons[$categoryNum])) {
                                                    $iconPath = 'nest-frontend/assets/imgs/theme/icons/' . $customIcons[$categoryNum];
                                                } else {
                                                    $iconPath = 'nest-frontend/assets/imgs/theme/icons/category-' . (($index % 10) + 1) . '.svg';
                                                }
                                            @endphp
                                            <img src="{{ asset($iconPath) }}" alt="{{ $category->name }}" style="max-height:55px; max-width:65px; object-fit:contain;" />
                                        </a>
                                    </figure>
                                    <h6 style="margin:6px 0 0 0; font-size:1.1rem; text-align:center; line-height:1.2;">
                                        <a href="{{ route('catalogo.index', ['categoria' => $category->id]) }}">{{ $category->name }}</a>
                                    </h6>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const scroller = document.getElementById('carausel-8-columns');
                            const prev = document.querySelector('#carausel-8-columns-arrows .slider-prev');
                            const next = document.querySelector('#carausel-8-columns-arrows .slider-next');
                            if (!scroller || !prev || !next) return;
                            const amount = () => Math.min(360, Math.max(220, Math.floor(scroller.clientWidth * 0.6)));
                            const scrollToDir = (dir) => scroller.scrollBy({ left: dir * amount(), behavior: 'smooth' });
                            prev.addEventListener('click', () => scrollToDir(-1));
                            next.addEventListener('click', () => scrollToDir(1));
                        });
                    </script>
                </section>
               
                <!-- Título dinámico de categoría seleccionada -->
                <div class="mb-3 mt-2">
                    <h2 class="text-start" style="font-size:1.2rem; font-weight:600; color:#28a745;">
                        @if(request()->has('categoria'))
                            @php
                                $selectedCategory = $categories->firstWhere('id', request()->categoria);
                            @endphp
                            {{ $selectedCategory ? $selectedCategory->name : 'Todos los productos' }}
                        @else
                            Todos los productos
                        @endif
                    </h2>
                </div>

                <!-- Filtro por subcategoría -->
                @if(request()->has('categoria') && $subcategories->count() > 0)
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <h6 class="mb-0 me-3" style="color:#253D4E; font-weight:500;">Filtrar por subcategoría:</h6>
                        @if(request()->has('subcategoria'))
                            <a href="{{ route('catalogo.index', ['categoria' => request()->categoria]) }}" 
                               class="btn btn-sm btn-outline-secondary" style="font-size:0.8rem;">
                                <i class="fi-rs-cross-small me-1"></i>Limpiar filtro
                            </a>
                        @endif
                    </div>
                    <div class="subcategory-filter" style="display:flex; gap:8px; overflow-x:auto; padding-bottom:8px; scrollbar-width:thin;">
                        @foreach($subcategories as $subcategory)
                            @php
                                $isActive = request()->subcategoria == $subcategory->id;
                                $url = route('catalogo.index', array_merge(request()->query(), ['subcategoria' => $subcategory->id]));
                            @endphp
                            <a href="{{ $url }}" 
                               class="subcategory-btn" 
                               style="display:inline-flex; align-items:center; padding:0.5rem 1rem; border:1px solid {{ $isActive ? '#28a745' : '#dee2e6' }}; border-radius:20px; text-decoration:none; color:{{ $isActive ? 'white' : '#6c757d' }}; background-color:{{ $isActive ? '#28a745' : 'white' }}; font-size:0.9rem; font-weight:500; white-space:nowrap; transition:all 0.3s ease;"
                               onmouseover="if(!this.classList.contains('active')) { this.style.borderColor='#28a745'; this.style.color='#28a745'; }"
                               onmouseout="if(!this.classList.contains('active')) { this.style.borderColor='#dee2e6'; this.style.color='#6c757d'; }"
                               {{ $isActive ? 'class=active' : '' }}>
                                {{ $subcategory->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!--End nav-tabs-->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-all" role="tabpanel" aria-labelledby="tab-all">
                        @if($products->isEmpty())
                            <div class="text-center py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; padding: 3rem 2rem;">
                                <div class="mb-4">
                                    <i class="fi-rs-box" style="font-size: 4rem; color: #28a745; opacity: 0.7;"></i>
                                </div>
                                <h3 style="color: #253D4E; font-weight: 600; margin-bottom: 1rem;">
                                    ¡Estamos preparando algo especial!
                                </h3>
                                <p class="text-muted" style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                                    Agregamos productos nuevos rutinariamente. Esta categoría está temporalmente vacía, pero pronto estará llena de opciones increíbles para ti.
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('catalogo.index') }}" class="btn btn-success" style="background-color: #28a745; border: none; padding: 0.75rem 2rem; border-radius: 8px;">
                                        <i class="fi-rs-arrow-left me-2"></i>
                                        Ver todas las categorías
                                    </a>
                                </div>
                            </div>
                        @else
                        <div class="row product-grid-4">
                            @foreach($products as $product)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-1-5">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{ route('catalogo.producto', $product->id) }}">
                                                @if($product->images->count() > 0)
                                                    <img class="default-img" src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" />
                                                    @if($product->images->count() > 1)
                                                        <img class="hover-img" src="{{ asset('storage/' . $product->images->skip(1)->first()->image_path) }}" alt="{{ $product->name }}" />
                                                    @else
                                                        <img class="hover-img" src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" />
                                                    @endif
                                                @else
                                                    <img class="default-img" src="{{ asset('nest-frontend/assets/imgs/shop/product-1-1.jpg') }}" alt="{{ $product->name }}" />
                                                    <img class="hover-img" src="{{ asset('nest-frontend/assets/imgs/shop/product-1-2.jpg') }}" alt="{{ $product->name }}" />
                                                @endif
                                            </a>
                                        </div>
                                        @if($product->promotional_price && $product->promotional_price < $product->price)
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="best">-{{ number_format((($product->price - $product->promotional_price) / $product->price) * 100, 0) }}%</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="{{ route('catalogo.index', ['categoria' => $product->category->id]) }}" style="color: #7E7E7E; font-size: 0.85rem;">{{ $product->category->name }}</a>
                                        </div>
                                        <h2 style="font-size: 1rem; line-height: 1.3; margin-bottom: 0.75rem;">
                                            <a href="{{ route('catalogo.producto', $product->id) }}" style="color: #253D4E;">{{ $product->name }}</a>
                                        </h2>
                                      
                                        <div class="product-card-bottom" style="display: flex; flex-direction: column; gap: 0.5rem;">
                                            <div class="product-price" style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: nowrap;">
                                                @if($product->promotional_price && $product->promotional_price < $product->price)
                                                    <span style="color: #28a745; font-weight: 700; font-size: 1.1rem; white-space: nowrap;">S/. {{ number_format($product->promotional_price, 2) }}</span>
                                                    <span class="old-price" style="color: #adadad; font-size: 0.9rem; white-space: nowrap;">S/. {{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span style="color: #28a745; font-weight: 700; font-size: 1.1rem; white-space: nowrap;">S/. {{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="add-cart" style="width: 100%;">
                                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline" style="width: 100%;">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="add" style="background-color: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; width: 100%; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; gap: 0.3rem; transition: background-color 0.3s;">
                                                        <i class="fi-rs-shopping-cart" style="font-size: 1rem;"></i>Agregar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            @endforeach
                        </div>
                        <!--End product-grid-4-->
                        @endif
                    </div>
                    <!--End tab-all-->
                </div>
                <!--End tab-content-->
            </section>
            <!--Products Tabs-->
        </div>
    </div>
</div>
<!--End container-->

<!-- Sección de categorías movida más arriba -->


<!--End 4 columns-->
@endsection
