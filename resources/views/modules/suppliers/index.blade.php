@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar SweetAlert para mensajes de éxito o error
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: @json(session('success')),
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: @json(session('error')),
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
            // Confirmación para eliminar
            document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = btn.closest('form');
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: '¡Esta acción no se puede deshacer!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        focusCancel: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
@section('title', 'Proveedores')
@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">
                Proveedores
            </h2>
            <p>
                Aquí puedes administrar los proveedores de tu tienda. Puedes crear, editar, eliminar y exportar proveedores.
            </p>
        </div>
        <div>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm rounded">
                Nuevo Proveedor
            </a>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <input type="text" placeholder="Search..." class="form-control" />
                </div>
            </div>
        </header>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Datos</th>
                            <th>
                                Whatsapp
                            </th>
                            <th>Hora Apertura</th>
                            <th>Hora Cierre</th>
                            <th>Estado</th>
                            <th class="text-center">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td width="40%">
                                    <a href="#" class="itemside">
                                        <div class="left">
                                            @if ($supplier->image)
                                                <img src="{{ asset('storage/' . $supplier->image) }}"
                                                    class="img-sm img-avatar" alt="Imagen del Proveedor"
                                                    onerror="this.onerror=null;this.src='{{ asset('imgs/items/1.jpg') }}';" />
                                            @else
                                                <img src="{{ asset('imgs/items/1.jpg') }}" class="img-sm img-thumbnail"
                                                    alt="No image" />
                                            @endif
                                        </div>
                                        <div class="info pl-3">
                                            <h6 class="mb-0 title">{{ $supplier->name }}</h6>
                                            <small class="text-muted">Nro. Documento:
                                                {{ $supplier->document_number }}</small>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    @if ($supplier->whatsapp)
                                        <a href="https://wa.me/51{{ preg_replace('/[^0-9]/', '', $supplier->whatsapp) }}"
                                            target="_blank">
                                            {{ $supplier->whatsapp }}
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $supplier->opening_time }}</td>
                                <td>{{ $supplier->closing_time }}</td>
                                <td>
                                    @if ($supplier->status === 'inactive')
                                        <span class="badge rounded-pill alert-danger">Inactivo</span>
                                    @else
                                        <span class="badge rounded-pill alert-success">Activo</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                        class="btn btn-xs btn-warning btn-editar me-1" title="Editar">
                                        <i class="material-icons md-edit" style="font-size:16px;vertical-align:middle;"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-xs btn-danger btn-eliminar" title="Eliminar">
                                            <i class="material-icons md-delete"
                                                style="font-size:16px;vertical-align:middle;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="pagination-area mt-15 mb-50">
        @if (method_exists($suppliers, 'links'))
            <div class="d-flex justify-content-start">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = btn.closest('form');
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: '¡Esta acción no se puede deshacer!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        focusCancel: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
