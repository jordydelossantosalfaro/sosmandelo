@extends('layouts.catalog')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Checkout</h1>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Información del Cliente</h5>
                </div>
                <div class="card-body">
                    <form id="checkout-form" action="{{ route('cart.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Número de celular <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror"
                                id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="delivery_address" class="form-label">Dirección de entrega <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('delivery_address') is-invalid @enderror"
                                id="delivery_address" name="delivery_address" rows="3" required>{{ old('delivery_address') }}</textarea>
                            @error('delivery_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Correo electrónico (opcional)</label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">Notas / Instrucciones adicionales (opcional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="card border-light bg-light">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="invoice_required" value="1"
                                            id="invoice_required" {{ old('invoice_required') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="invoice_required">
                                            Deseo factura
                                        </label>
                                    </div>                                    <div id="invoice-fields" class="mt-3" style="display: {{ old('invoice_required') ? 'block' : 'none' }};">
                                        <div class="mb-3">
                                            <label for="invoice_ruc" class="form-label">RUC <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('invoice_ruc') is-invalid @enderror"
                                                id="invoice_ruc" name="invoice_ruc" value="{{ old('invoice_ruc') }}">
                                            @error('invoice_ruc')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="invoice_business_name" class="form-label">Razón Social <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('invoice_business_name') is-invalid @enderror"
                                                id="invoice_business_name" name="invoice_business_name" value="{{ old('invoice_business_name') }}">
                                            @error('invoice_business_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="invoice_address" class="form-label">Dirección Fiscal <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('invoice_address') is-invalid @enderror"
                                                id="invoice_address" name="invoice_address" value="{{ old('invoice_address') }}">
                                            @error('invoice_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Método de Pago</h5>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_type" id="payment_cash" value="cash" checked>
                                    <label class="form-check-label" for="payment_cash">
                                        <i class="fas fa-money-bill text-success me-1"></i> Efectivo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_type" id="payment_digital" value="digital">
                                    <label class="form-check-label" for="payment_digital">
                                        <i class="fas fa-mobile-alt text-primary me-1"></i> Pago Digital
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_type" id="payment_card" value="card">
                                    <label class="form-check-label" for="payment_card">
                                        <i class="fas fa-credit-card text-info me-1"></i> Tarjeta
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_type" id="payment_transfer" value="transfer">
                                    <label class="form-check-label" for="payment_transfer">
                                        <i class="fas fa-university text-warning me-1"></i> Transferencia
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('terms_accepted') is-invalid @enderror"
                                    type="checkbox" id="terms_accepted" name="terms_accepted" value="1" required>
                                <label class="form-check-label" for="terms_accepted">
                                    Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">términos y condiciones</a> <span class="text-danger">*</span>
                                </label>
                                @error('terms_accepted')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-borderless">
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr>
                                    <td width="70">
                                        @if($item['product']->images->count() > 0)
                                            <img src="{{ asset('storage/' . $item['product']->images->first()->image_path) }}"
                                                alt="{{ $item['product']->name }}" class="img-fluid rounded" width="60">
                                        @else
                                            <img src="{{ asset('imgs/no-image.png') }}"
                                                alt="No imagen" class="img-fluid rounded" width="60">
                                        @endif
                                    </td>
                                    <td>
                                        <span class="d-block fw-bold">{{ $item['product']->name }}</span>
                                        <small class="text-muted">{{ $item['quantity'] }} x {{ number_format($item['price'], 2) }}</small>
                                    </td>
                                    <td class="text-end">{{ number_format($item['subtotal'], 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>{{ number_format($total, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Envío</span>
                        <span>Gratis</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong class="fs-5">{{ number_format($total, 2) }}</strong>
                    </div>

                    <button type="submit" form="checkout-form" class="btn btn-primary w-100 btn-lg">
                        Realizar Pedido
                    </button>
                </div>
            </div>

            <div class="d-grid">
                <a href="{{ route('cart.index') }}" class="btn btn-link text-muted">
                    <i class="fas fa-arrow-left me-2"></i> Volver al carrito
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Términos y Condiciones -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Términos y Condiciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Aceptación de los Términos</h6>
                <p>Al realizar una compra en SOS-Mandelo, usted acepta los términos y condiciones aquí descritos.</p>

                <h6>2. Precios y Pagos</h6>
                <p>Los precios mostrados incluyen impuestos. El pago debe realizarse en su totalidad para procesar el pedido.</p>

                <h6>3. Entregas</h6>
                <p>Las entregas se realizan en el área metropolitana en un plazo de 24 a 48 horas hábiles.</p>

                <h6>4. Cancelaciones y Devoluciones</h6>
                <p>Las cancelaciones deben realizarse dentro de las primeras 2 horas de realizado el pedido. Las devoluciones se aceptan hasta 7 días después de recibido el producto.</p>

                <h6>5. Uso de Datos Personales</h6>
                <p>Sus datos personales serán utilizados únicamente para procesar su pedido y mejorar su experiencia de compra.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const invoiceCheckbox = document.getElementById('invoice_required');
        const invoiceFields = document.getElementById('invoice-fields');

        invoiceCheckbox.addEventListener('change', function() {
            invoiceFields.style.display = this.checked ? 'block' : 'none';
        });
    });
</script>
@endpush
