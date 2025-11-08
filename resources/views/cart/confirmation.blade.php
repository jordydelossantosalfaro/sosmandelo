@extends('layouts.catalog')

@section('title', 'Pedido Confirmado')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <div class="mb-4">
            <div class="bg-success text-white d-inline-flex justify-content-center align-items-center rounded-circle" style="width: 80px; height: 80px;">
                <i class="fas fa-check fa-3x"></i>
            </div>
        </div>
        <h1 class="mb-2">¡Gracias por tu pedido!</h1>
        <p class="text-muted">Tu pedido ha sido recibido y se está procesando.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detalles del pedido</h5>
                        <span class="badge bg-info">Pedido #{{ $order->order_number }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h6>Información del cliente</h6>
                            <p class="mb-1"><strong>Nombre:</strong> {{ $order->customer_name }}</p>
                            <p class="mb-1"><strong>Teléfono:</strong> {{ $order->customer_phone }}</p>
                            @if($order->customer_email)
                                <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email }}</p>
                            @endif
                            <p class="mb-0"><strong>Dirección de entrega:</strong> {{ $order->delivery_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Detalles del pedido</h6>
                            <p class="mb-1"><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p class="mb-1">
                                <strong>Método de pago:</strong>
                                @switch($order->payment_type)
                                    @case('cash')
                                        Efectivo
                                        @break
                                    @case('digital')
                                        Pago Digital
                                        @break
                                    @case('card')
                                        Tarjeta
                                        @break
                                    @case('transfer')
                                        Transferencia
                                        @break
                                    @default
                                        {{ $order->payment_type }}
                                @endswitch
                            </p>
                            <p class="mb-1">
                                <strong>Estado:</strong>
                                <span class="badge bg-warning text-dark">
                                    @switch($order->status)
                                        @case('received')
                                            Recibido
                                            @break
                                        @case('confirmed')
                                            Confirmado
                                            @break
                                        @case('prepared')
                                            Preparado
                                            @break
                                        @case('in_transit')
                                            En tránsito
                                            @break
                                        @case('delivered')
                                            Entregado
                                            @break
                                        @case('rescheduled')
                                            Reprogramado
                                            @break
                                        @case('cancelled')
                                            Cancelado
                                            @break
                                        @default
                                            {{ $order->status }}
                                    @endswitch
                                </span>
                            </p>
                            @if($order->invoice_required)
                                <p class="mb-0"><strong>Factura requerida:</strong> Sí</p>
                            @endif
                        </div>
                    </div>

                    <h6>Productos</h6>
                    <div class="table-responsive mb-3">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td class="text-end"><strong>{{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                        <div class="mb-3">
                            <h6>Notas</h6>
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="alert alert-info">
                <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i> Próximos pasos</h6>
                <p class="mb-0">Recibirás una llamada o mensaje para confirmar tu pedido en breve. Si tienes alguna pregunta, puedes contactarnos al <strong>123-456-7890</strong> o por correo a <strong>info@sosmandelo.com</strong>.</p>
            </div>

            <div class="d-grid">
                <a href="{{ route('catalogo.index') }}" class="btn btn-primary">
                    Continuar comprando
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
