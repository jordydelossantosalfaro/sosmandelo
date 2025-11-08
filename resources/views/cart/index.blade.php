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
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-3">Producto</th>
                                        <th scope="col" width="120">Precio</th>
                                        <th scope="col" width="120">Cantidad</th>
                                        <th scope="col" width="120">Subtotal</th>
                                        <th scope="col" width="60"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3" style="width: 60px; height: 60px;">
                                                    @if($item['product']->images->count() > 0)
                                                        <img src="{{ asset('storage/' . $item['product']->images->first()->image_path) }}"
                                                            alt="{{ $item['product']->name }}" class="img-fluid rounded">
                                                    @else
                                                        <img src="{{ asset('imgs/no-image.png') }}"
                                                            alt="No imagen" class="img-fluid rounded">
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $item['product']->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item['price'], 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                                        class="form-control form-control-sm">
                                                    <button class="btn btn-sm btn-outline-secondary" type="submit">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td>{{ number_format($item['subtotal'], 2) }}</td>
                                        <td>
                                            <a href="{{ route('cart.remove', $item['product']->id) }}" class="text-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
