@extends('layouts.catalog')

@section('title', 'Carrito de Compras')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Carrito de Compras</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Productos en tu carrito</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($cartItems as $item)
                                <div class="list-group-item py-3">
                                    <div class="row align-items-center">
                                        <div class="col-3 col-md-2">
                                            @if($item['product']->images->count() > 0)
                                                <img src="{{ asset('storage/' . $item['product']->images->first()->image_path) }}" alt="{{ $item['product']->name }}" class="img-fluid rounded" style="width:48px;height:48px;object-fit:cover;">
                                            @else
                                                <img src="{{ asset('imgs/no-image.png') }}" alt="No imagen" class="img-fluid rounded" style="width:48px;height:48px;object-fit:cover;">
                                            @endif
                                        </div>
                                        <div class="col-5 col-md-6">
                                            <h6 class="mb-1">{{ $item['product']->name }}</h6>
                                            <div class="text-muted small">S/. {{ number_format($item['price'], 2) }}</div>
                                        </div>
                                        <div class="col-4 col-md-4 text-end">
                                            <div class="d-flex justify-content-end align-items-center">
                                                <form action="{{ route('cart.update') }}" method="POST" class="me-2 d-inline-flex" style="align-items:center;">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                    <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                                    <button class="btn btn-sm btn-outline-secondary" type="submit" title="Restar cantidad" aria-label="Restar una unidad de {{ $item['product']->name }}" @if($item['quantity'] <= 1) disabled @endif>-</button>
                                                </form>

                                                <span class="px-2">{{ $item['quantity'] }}</span>

                                                <form action="{{ route('cart.update') }}" method="POST" class="ms-2 d-inline-flex" style="align-items:center;">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                                    <button class="btn btn-sm btn-outline-secondary" type="submit" title="Sumar cantidad" aria-label="Sumar una unidad de {{ $item['product']->name }}">+</button>
                                                </form>
                                            </div>
                                            <div class="mt-2">
                                                <strong>Subtotal:</strong> S/. {{ number_format($item['subtotal'], 2) }}
                                            </div>
                                            <div class="mt-2">
                                                <a href="{{ route('cart.remove', $item['product']->id) }}" class="text-danger" title="Eliminar producto" aria-label="Eliminar {{ $item['product']->name }} del carrito">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('catalogo.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Continuar Comprando
                    </a>
                    <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger">
                        <i class="fas fa-trash me-2"></i> Vaciar Carrito
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Resumen del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span>{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Envío</span>
                            <span>Calculado en el checkout</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong>{{ number_format($total, 2) }}</strong>
                        </div>
                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary w-100">
                            Proceder al Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart fa-4x text-muted"></i>
            </div>
            <h3>Tu carrito está vacío</h3>
            <p class="text-muted">Parece que aún no has agregado ningún producto a tu carrito.</p>
            <a href="{{ route('catalogo.index') }}" class="btn btn-primary">
                Explorar Productos
            </a>
        </div>
    @endif
</div>
@endsection
