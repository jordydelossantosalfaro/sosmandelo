@section('title', 'Subcategorías')
@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">
                Subcategorías
            </h2>
            <p>
                Aquí puedes administrar las subcategorías de productos. Puedes crear nuevas subcategorías, editar las existentes y eliminarlas según sea necesario.
            </p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <form id="form-subcategoria"
                        data-store-url="{{ route('admin.subcategories.store') }}"
                        data-update-url="{{ route('admin.subcategories.update', [':id']) }}"
                        data-show-url="{{ route('admin.subcategories.show', [':id']) }}"
                        data-delete-url="{{ route('admin.subcategories.destroy', [':id']) }}">
                        <input type="hidden" name="id" id="subcategory_id" />
                        <div class="mb-4">
                            <label for="subcategory_category_id" class="form-label">Categoría</label>
                            <select name="category_id" id="subcategory_category_id" class="form-select" required>
                                <option value="">Seleccione una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="subcategory_name" class="form-label">Nombre</label>
                            <input type="text" name="name" id="subcategory_name" class="form-control"
                                placeholder="Nombre de la subcategoría" required />
                        </div>
                        <div class="mb-4">
                            <label for="subcategory_status" class="form-label">Estado</label>
                            <select name="status" id="subcategory_status" class="form-select" required>
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="btn-submit">Crear subcategoría</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table id="subcategories-table" class="table table-hover" data-url="{{ route('admin.subcategories.data') }}">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Categoría</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables Buttons & dependencies -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="{{ asset('js/subcategories.js') }}"></script>
@endpush
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
