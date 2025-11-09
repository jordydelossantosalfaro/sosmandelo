@extends('layouts.catalog')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="container mb-30">
    <div class="row flex-row-reverse">
        <div class="col-lg-4-5">
            <section class="product-tabs section-padding position-relative">
                <div class="section-title style-2 wow animate__animated animate__fadeIn">
                    <h3>Nuestros productos</h3>
                    <ul class="nav nav-tabs links" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ !request()->has('categoria') ? 'active' : '' }}"
                                    id="nav-tab-all"
                                    data-bs-toggle="tab"
                                    data-bs-target="#tab-all"
                                    type="button"
                                    role="tab"
                                    aria-controls="tab-all"
                                    aria-selected="{{ !request()->has('categoria') ? 'true' : 'false' }}">
                                Todos
                            </button>
                        </li>
                        @foreach($categories->take(6) as $index => $category)
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('catalogo.index', ['categoria' => $category->id]) }}"
                               class="nav-link {{ request()->categoria == $category->id ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <!--End nav-tabs-->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-all" role="tabpanel" aria-labelledby="tab-all">
                        @if($products->isEmpty())
                            <div class="alert alert-warning">
                                <p>No products found.</p>
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
                                        <div class="product-action-1">
                                            <a aria-label="Quick view" class="action-btn" href="{{ route('catalogo.producto', $product->id) }}"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        @if($product->promotional_price && $product->promotional_price < $product->price)
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="best">-{{ number_format((($product->price - $product->promotional_price) / $product->price) * 100, 0) }}%</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="{{ route('catalogo.index', ['categoria' => $product->category->id]) }}">{{ $product->category->name }}</a>
                                        </div>
                                        <h2><a href="{{ route('catalogo.producto', $product->id) }}">{{ $product->name }}</a></h2>
                                      
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                @if($product->promotional_price && $product->promotional_price < $product->price)
                                                    <span>S/. {{ number_format($product->promotional_price, 2) }}</span>
                                                    <span class="old-price">S/. {{ number_format($product->price, 2) }}</span>
                                                @else
                                                    <span>S/. {{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="add-cart">
                                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="add">
                                                        <i class="fi-rs-shopping-cart mr-5"></i>Agregar
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

        <div class="col-lg-1-5 primary-sidebar sticky-sidebar pt-30">
            <div class="sidebar-widget widget-category-2 mb-30">
                <h5 class="section-title style-1 mb-30">Category</h5>
                <ul>
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('catalogo.index', ['categoria' => $category->id]) }}" class="{{ request()->categoria == $category->id ? 'active' : '' }}">
                            <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/category-1.svg') }}" alt="" />
                            {{ $category->name }}
                        </a>
                        <span class="count">{{ $category->products_count ?? 0 }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!-- Fillter By Price -->
            <div class="sidebar-widget price_range range mb-30">
                <h5 class="section-title style-1 mb-30">Fill by price</h5>
                <div class="price-filter">
                    <div class="price-filter-inner">
                        <div id="slider-range" class="mb-20"></div>
                        <div class="d-flex justify-content-between">
                            <div class="caption">From: <strong id="slider-range-value1" class="text-brand"></strong></div>
                            <div class="caption">To: <strong id="slider-range-value2" class="text-brand"></strong></div>
                        </div>
                    </div>
                </div>
                <div class="list-group">
                    <div class="list-group-item mb-10 mt-10">
                        @if($brands->count() > 0)
                        <label class="fw-900">Brand</label>
                        <div class="custome-checkbox">
                            @foreach($brands->take(5) as $brand)
                            <input class="form-check-input" type="checkbox" name="checkbox" id="brand{{ $brand->id }}" value="{{ $brand->id }}" {{ request()->marca == $brand->id ? 'checked' : '' }} />
                            <label class="form-check-label" for="brand{{ $brand->id }}"><span>{{ $brand->name }}</span></label>
                            <br />
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                <a href="shop-grid-right.html" class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5"></i> Fillter</a>
            </div>
            <!-- Product sidebar Widget -->
            <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
                <h5 class="section-title style-1 mb-30">New products</h5>
                @php
                    $newProducts = \App\Models\Product::latest()
                        ->take(3)
                        ->get();
                @endphp
                @foreach($newProducts as $newProduct)
                <div class="single-post clearfix">
                    <div class="image">
                        @if($newProduct->images->count() > 0)
                            <img src="{{ asset('storage/' . $newProduct->images->first()->image_path) }}" alt="{{ $newProduct->name }}" />
                        @else
                            <img src="{{ asset('nest-frontend/assets/imgs/shop/thumbnail-3.jpg') }}" alt="{{ $newProduct->name }}" />
                        @endif
                    </div>
                    <div class="content pt-10">
                        <h5><a href="{{ route('catalogo.producto', $newProduct->id) }}">{{ Str::limit($newProduct->name, 30) }}</a></h5>
                        <p class="price mb-0 mt-5">${{ number_format($newProduct->promotional_price ?? $newProduct->price, 2) }}</p>
                        <div class="product-rate">
                            <div class="product-rating" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="banner-img wow fadeIn mb-lg-0 animated d-lg-block d-none">
                <img src="{{ asset('nest-frontend/assets/imgs/banner/banner-11.png') }}" alt="" />
                <div class="banner-text">
                    <span>Oganic</span>
                    <h4>
                        Save 17% <br />
                        on <span class="text-brand">Oganic</span><br />
                        Juice
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End container-->

<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title">
            <div class="title">
                <h3>Shop by Categories</h3>
                <a class="show-all" href="{{ route('catalogo.index') }}">
                    All Categories
                    <i class="fi-rs-angle-right"></i>
                </a>
            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carausel-8-columns-arrow" id="carausel-8-columns-arrows"></div>
        </div>
        <div class="carausel-8-columns-cover position-relative">
            <div class="carausel-8-columns" id="carausel-8-columns">
                @foreach($categories as $index => $category)
                <div class="card-1">
                    <figure class="img-hover-scale overflow-hidden">
                        <a href="{{ route('catalogo.index', ['categoria' => $category->id]) }}">
                            <img src="{{ asset('nest-frontend/assets/imgs/theme/icons/category-' . (($index % 10) + 1) . '.svg') }}" alt="{{ $category->name }}" />
                        </a>
                    </figure>
                    <h6>
                        <a href="{{ route('catalogo.index', ['categoria' => $category->id]) }}">{{ $category->name }}</a>
                    </h6>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!--End category slider-->

<section class="section-padding mb-30">
    <div class="container">
        <div class="row">
            @php
                $topSellingProducts = \App\Models\Product::latest()
                    ->take(9)
                    ->get()
                    ->chunk(3);
            @endphp
            @foreach($topSellingProducts as $chunk)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeIn" data-wow-delay=".{{ $loop->index }}s">
                <h4 class="section-title style-1 mb-30 animated animated">Top Selling</h4>
                <div class="product-list-small animated animated">
                    @foreach($chunk as $product)
                    <article class="row align-items-center hover-up">
                        <figure class="col-md-4 mb-0">
                            <a href="{{ route('catalogo.producto', $product->id) }}">
                                @if($product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" />
                                @else
                                    <img src="{{ asset('nest-frontend/assets/imgs/shop/thumbnail-1.jpg') }}" alt="{{ $product->name }}" />
                                @endif
                            </a>
                        </figure>
                        <div class="col-md-8 mb-0">
                            <h6>
                                <a href="{{ route('catalogo.producto', $product->id) }}">{{ Str::limit($product->name, 40) }}</a>
                            </h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                            <div class="product-price">
                                @if($product->promotional_price && $product->promotional_price < $product->price)
                                    <span>${{ number_format($product->promotional_price, 2) }}</span>
                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span>${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--End 4 columns-->
@endsection
