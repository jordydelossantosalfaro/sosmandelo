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
    <div class="mt-5">
        <h3 class="mb-4">Productos Relacionados</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($relatedProducts as $related)
                <div class="col">
                    <div class="card h-100 product-card">
                        @if($related->promotional_price && $related->promotional_price < $related->price)
                            <div class="price-badge">
                                <span class="badge bg-danger">
                                    -{{ number_format((($related->price - $related->promotional_price) / $related->price) * 100, 0) }}%
                                </span>
                            </div>
                        @endif

                        @if($related->images->count() > 0)
                            <img src="{{ asset('storage/' . $related->images->first()->image_path) }}" class="card-img-top" alt="{{ $related->name }}">
                        @else
                            <img src="{{ asset('imgs/no-image.png') }}" class="card-img-top" alt="Sin imagen">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $related->name }}</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($related->promotional_price && $related->promotional_price < $related->price)
                                        <span class="text-decoration-line-through text-muted">{{ number_format($related->price, 2) }}</span>
                                        <span class="fw-bold text-danger">{{ number_format($related->promotional_price, 2) }}</span>
                                    @else
                                        <span class="fw-bold">{{ number_format($related->price, 2) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('catalogo.producto', $related->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
</script>
@endpush
