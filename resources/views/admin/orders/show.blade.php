@extends('layouts.app')

@section('title', 'Detalle de Orden')

@section('content')
<div class="content-header">
    <div>
        <h2 class="content-title card-title">Detalle de la Orden</h2>
        <p>Información detallada de la orden: {{ $order->order_number }}</p>
    </div>
    <div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light"><i class="material-icons md-arrow_back"></i> Volver a la Lista</a>
    </div>
</div>

<div class="card">
    <header class="card-header">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 mb-lg-0 mb-15">
                <span>
                    <i class="material-icons md-calendar_today"></i>
                    <b>{{ $order->created_at->format('d/m/Y H:i') }}</b>
                </span>
                <br>
                <small class="text-muted">Orden ID: {{ $order->order_number }}</small>
            </div>
            <div class="col-lg-6 col-md-6 ms-auto text-md-end">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('PUT')
                    <select class="form-select d-inline-block mb-lg-0 mr-5 mw-200" name="status" id="order-status">
                        <option disabled>Cambiar estado</option>
                        <option value="received" {{ $order->status == 'received' ? 'selected' : '' }}>Recibida</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmada</option>
                        <option value="prepared" {{ $order->status == 'prepared' ? 'selected' : '' }}>Preparada</option>
                        <option value="in_transit" {{ $order->status == 'in_transit' ? 'selected' : '' }}>En Tránsito</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Entregada</option>
                        <option value="rescheduled" {{ $order->status == 'rescheduled' ? 'selected' : '' }}>Reprogramada</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
                <a class="btn btn-secondary print ms-2" href="#" onclick="window.print();">
                    <i class="icon material-icons md-print"></i>
                </a>
            </div>
        </div>
    </header>
    <!-- card-header end// -->

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row mb-50 mt-20 order-info-wrap">
            <div class="col-md-4">
                <article class="icontext align-items-start">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-person"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1">Cliente</h6>
                        <p class="mb-1">
                            {{ $order->customer_name }} <br>
                            @if($order->customer_email)
                                {{ $order->customer_email }} <br>
                            @endif
                            {{ $order->customer_phone }}
                        </p>
                    </div>
                </article>
            </div>
            <!-- col// -->
            <div class="col-md-4">
                <article class="icontext align-items-start">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-local_shipping"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1">Información del pedido</h6>
                        <p class="mb-1">
                            Tipo de pedido:
                            @php
                                $orderTypeText = [
                                    'standard' => 'Estándar',
                                    'express' => 'Express',
                                    'pickup' => 'Recojo en Tienda'
                                ][$order->order_type] ?? 'Estándar';
                            @endphp
                            {{ $orderTypeText }}
                            <br>
                            Método de pago:
                            @php
                                $paymentTypeText = [
                                    'cash' => 'Efectivo',
                                    'digital' => 'Digital',
                                    'card' => 'Tarjeta',
                                    'transfer' => 'Transferencia'
                                ][$order->payment_type] ?? 'Desconocido';
                            @endphp
                            {{ $paymentTypeText }}
                            <br>
                            Estado:
                            @php
                                $statusText = [
                                    'received' => 'Recibida',
                                    'confirmed' => 'Confirmada',
                                    'prepared' => 'Preparada',
                                    'in_transit' => 'En Tránsito',
                                    'delivered' => 'Entregada',
                                    'rescheduled' => 'Reprogramada',
                                    'cancelled' => 'Cancelada'
                                ][$order->status] ?? 'Desconocido';
                            @endphp
                            {{ $statusText }}
                        </p>
                    </div>
                </article>
            </div>
            <!-- col// -->
            <div class="col-md-4">
                <article class="icontext align-items-start">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-place"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1">Entregar a</h6>
                        <p class="mb-1">
                            {{ $order->delivery_address }}
                        </p>
                    </div>
                </article>
            </div>
            <!-- col// -->
        </div>
        <!-- row // -->

        <div class="row">
            <div class="col-lg-7">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="40%">Producto</th>
                                <th width="20%">Precio Unitario</th>
                                <th width="20%">Cantidad</th>
                                <th width="20%" class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <a class="itemside" href="#">
                                        <div class="left">
                                            @if($item->product && $item->product->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                                    width="40" height="40" class="img-xs" alt="{{ $item->product_name }}">
                                            @else
                                                <img src="{{ asset('imgs/no-image.png') }}"
                                                    width="40" height="40" class="img-xs" alt="{{ $item->product_name }}">
                                            @endif
                                        </div>
                                        <div class="info">{{ $item->product_name }}</div>
                                    </a>
                                </td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4">
                                    <article class="float-end">
                                        <dl class="dlist">
                                            <dt>Subtotal:</dt>
                                            <dd>{{ number_format($order->total_amount, 2) }}</dd>
                                        </dl>
                                        <dl class="dlist">
                                            <dt>Costo de envío:</dt>
                                            <dd>Gratis</dd>
                                        </dl>
                                        <dl class="dlist">
                                            <dt>Total:</dt>
                                            <dd><b class="h5">{{ number_format($order->total_amount, 2) }}</b></dd>
                                        </dl>
                                        <dl class="dlist">
                                            <dt class="text-muted">Estado de Pago:</dt>
                                            <dd>
                                                @php
                                                    $paymentStatusClass = $order->payment_status == 'completed' ? 'alert-success text-success' : 'alert-warning text-warning';
                                                    $paymentStatusText = $order->payment_status == 'completed' ? 'Pagado' : 'Pendiente';
                                                @endphp
                                                <span class="badge rounded-pill {{ $paymentStatusClass }}">{{ $paymentStatusText }}</span>
                                            </dd>
                                        </dl>
                                        <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-flex">
                                                <select name="payment_status" class="form-select form-select-sm me-2">
                                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                                    <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Completado</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                                            </div>
                                        </form>
                                    </article>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive// -->
            </div>
            <!-- col// -->
            <div class="col-lg-1"></div>
            <div class="col-lg-4">
                @if($order->invoice_required)
                <div class="box shadow-sm bg-light mb-4">
                    <h6 class="mb-15">Información de Facturación</h6>
                    <p class="mb-1"><strong>RUC:</strong> {{ $order->invoice_ruc }}</p>
                    <p class="mb-1"><strong>Razón Social:</strong> {{ $order->invoice_business_name }}</p>
                    <p class="mb-1"><strong>Dirección Fiscal:</strong> {{ $order->invoice_address }}</p>
                    <p class="mb-0">
                        <strong>Estado de Facturación:</strong>
                        @php
                            $invoiceStatusClass = $order->invoice_status == 'paid' ? 'alert-success text-success' : 'alert-warning text-warning';
                            $invoiceStatusText = $order->invoice_status == 'paid' ? 'Pagada' : 'Pendiente';
                        @endphp
                        <span class="badge rounded-pill {{ $invoiceStatusClass }}">{{ $invoiceStatusText }}</span>
                    </p>
                    <form action="{{ route('admin.orders.update-invoice-status', $order) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <select name="invoice_status" class="form-select form-select-sm me-2">
                                <option value="pending" {{ $order->invoice_status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="paid" {{ $order->invoice_status == 'paid' ? 'selected' : '' }}>Pagada</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
                @endif
                <div class="box shadow-sm bg-light">
                    <h6 class="mb-15">Notas</h6>
                    <form action="{{ route('admin.orders.save-notes', $order) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="notes" rows="4" placeholder="Escribir notas sobre esta orden">{{ $order->notes }}</textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Guardar Notas</button>
                    </form>
                </div>
            </div>
            <!-- col// -->
        </div>
    </div>
    <!-- card-body end// -->
</div>
<!-- card end// -->
@endsection
