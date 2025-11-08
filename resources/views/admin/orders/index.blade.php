@extends('layouts.app')

@section('title', 'Listado de Órdenes')

@section('content')
<div class="content-header">
    <div>
        <h2 class="content-title card-title">Lista de Órdenes</h2>
        <p>Gestiona todas las órdenes recibidas en el sistema</p>
    </div>
    <div>
        <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex">
            <input type="text" placeholder="Buscar número de orden" name="search" value="{{ request()->search }}" class="form-control bg-white">
            <button type="submit" class="btn btn-light bg ms-2"><i class="material-icons md-search"></i></button>
        </form>
    </div>
</div>

<div class="card mb-4">
    <header class="card-header">
        <div class="row gx-3">
            <div class="col-lg-4 col-md-6 me-auto">
                <form action="{{ route('admin.orders.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" placeholder="Buscar por orden o cliente..." name="search" value="{{ request()->search }}" class="form-control">
                        <button type="submit" class="btn btn-light bg"><i class="material-icons md-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-lg-2 col-6 col-md-3">
                <form action="{{ route('admin.orders.index') }}" method="GET" id="status-form">
                    <select class="form-select" name="status" onchange="document.getElementById('status-form').submit();">
                        <option value="all" {{ request()->status == 'all' || !request()->status ? 'selected' : '' }}>Todos los estados</option>
                        <option value="received" {{ request()->status == 'received' ? 'selected' : '' }}>Recibida</option>
                        <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>Confirmada</option>
                        <option value="prepared" {{ request()->status == 'prepared' ? 'selected' : '' }}>Preparada</option>
                        <option value="in_transit" {{ request()->status == 'in_transit' ? 'selected' : '' }}>En Tránsito</option>
                        <option value="delivered" {{ request()->status == 'delivered' ? 'selected' : '' }}>Entregada</option>
                        <option value="rescheduled" {{ request()->status == 'rescheduled' ? 'selected' : '' }}>Reprogramada</option>
                        <option value="cancelled" {{ request()->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </form>
            </div>
            <div class="col-lg-2 col-6 col-md-3">
                <form action="{{ route('admin.orders.index') }}" method="GET" id="per-page-form">
                    <select class="form-select" name="per_page" onchange="document.getElementById('per-page-form').submit();">
                        <option value="20" {{ request()->per_page == '20' || !request()->per_page ? 'selected' : '' }}>Mostrar 20</option>
                        <option value="30" {{ request()->per_page == '30' ? 'selected' : '' }}>Mostrar 30</option>
                        <option value="50" {{ request()->per_page == '50' ? 'selected' : '' }}>Mostrar 50</option>
                        <option value="100" {{ request()->per_page == '100' ? 'selected' : '' }}>Mostrar 100</option>
                    </select>
                </form>
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

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nro. Documento</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Total</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Tipo de Pedido</th>
                        <th scope="col">Estado de Factura</th>
                        <th scope="col">Estado Pago</th>
                        <th scope="col">Tipo de Pago</th>
                        <th scope="col">Fecha y Hora</th>
                        <th scope="col" class="text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td><b>{{ $order->customer_name }}</b></td>
                        <td>{{ $order->customer_phone }}</td>
                        <td>{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            @php
                                $statusClass = [
                                    'received' => 'alert-primary',
                                    'confirmed' => 'alert-info',
                                    'prepared' => 'alert-warning',
                                    'in_transit' => 'alert-secondary',
                                    'delivered' => 'alert-success',
                                    'rescheduled' => 'alert-warning',
                                    'cancelled' => 'alert-danger'
                                ][$order->status] ?? 'alert-secondary';

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
                            <span class="badge rounded-pill {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                            @php
                                $orderTypeText = [
                                    'standard' => 'Estándar',
                                    'express' => 'Express',
                                    'pickup' => 'Recojo en Tienda'
                                ][$order->order_type] ?? 'Estándar';
                            @endphp
                            {{ $orderTypeText }}
                        </td>
                        <td>
                            @php
                                $invoiceStatusClass = $order->invoice_status == 'paid' ? 'alert-success' : 'alert-warning';
                                $invoiceStatusText = $order->invoice_status == 'paid' ? 'Pagado' : 'Pendiente';
                            @endphp
                            <span class="badge rounded-pill {{ $invoiceStatusClass }}">{{ $invoiceStatusText }}</span>
                        </td>
                        <td>
                            @php
                                $paymentStatusClass = $order->payment_status == 'completed' ? 'alert-success' : 'alert-warning';
                                $paymentStatusText = $order->payment_status == 'completed' ? 'Completado' : 'Pendiente';
                            @endphp
                            <span class="badge rounded-pill {{ $paymentStatusClass }}">{{ $paymentStatusText }}</span>
                        </td>
                        <td>
                            @php
                                $paymentTypeText = [
                                    'cash' => 'Efectivo',
                                    'digital' => 'Digital',
                                    'card' => 'Tarjeta',
                                    'transfer' => 'Transferencia'
                                ][$order->payment_type] ?? 'Desconocido';
                            @endphp
                            {{ $paymentTypeText }}
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-md rounded font-sm">Detalle</a>
                            <div class="dropdown d-inline-block">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm">
                                    <i class="material-icons md-more_horiz"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.orders.show', $order) }}">Ver detalle</a>
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="dropdown-item">Confirmar orden</button>
                                    </form>
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="dropdown-item text-danger">Cancelar orden</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">No se encontraron órdenes</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div> <!-- table-responsive //end -->

        <div class="pagination-area mt-15 mb-50">
            {{ $orders->links() }}
        </div>
    </div> <!-- card-body end// -->
</div> <!-- card end// -->
@endsection
