@php
    $isEdit = isset($product);
@endphp
@section('title', $isEdit ? 'Editar Producto' : 'Crear Producto')
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="content-header mb-4">
                <h2 class="content-title">
                    {{ $isEdit ? 'Editar Producto' : 'Crear Producto' }}
                </h2>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light rounded font-sm mr-5 text-body hover-up">
                        Cancelar
                    </a>
                    <button type="submit" form="product-form" class="btn btn-md rounded font-sm hover-up">
                        Guardar
                    </button>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">{{ $isEdit ? 'Editar Producto' : 'Nuevo Producto' }}</h4>
                </div>
                <div class="card-body">
                    <form id="product-form" method="POST"
                        action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="mb-3 col-md-8">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $isEdit ? $product->name : null) }}" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="brand_id" class="form-label">Marca</label>
                                <select class="form-select" name="brand_id" id="brand_id">
                                    <option value="">Selecciona</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id', $isEdit ? $product->brand_id : null) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="price" class="form-label">Precio</label>
                                <input type="number" step="0.01" class="form-control" name="price" id="price"
                                    value="{{ old('price', $isEdit ? $product->price : null) }}" />
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="promotional_price" class="form-label">Precio promocional</label>
                                <input type="number" step="0.01" class="form-control" name="promotional_price"
                                    id="promotional_price"
                                    value="{{ old('promotional_price', $isEdit ? $product->promotional_price : null) }}" />
                                @error('promotional_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="cost_price" class="form-label">Costos</label>
                                <input type="number" step="0.01" class="form-control" name="cost_price" id="cost_price"
                                    value="{{ old('cost_price', $isEdit ? $product->cost_price : null) }}" />
                                @error('cost_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="category_id" class="form-label">Categoría</label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option value="">Selecciona</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $isEdit ? $product->category_id : null) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="subcategory_id" class="form-label">Subcategoría</label>
                                <select class="form-select" name="subcategory_id" id="subcategory_id">
                                    <option value="">Selecciona</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}"
                                            {{ old('subcategory_id', $isEdit ? $product->subcategory_id : null) == $subcategory->id ? 'selected' : '' }}>
                                            {{ $subcategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subcategory_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="supplier_id" class="form-label">Proveedor</label>
                                <select class="form-select" name="supplier_id" id="supplier_id">
                                    <option value="">Selecciona</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id', $isEdit ? $product->supplier_id : null) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="tags" class="form-label">Tags</label>
                                <select class="form-control" name="tags[]" id="tags" multiple="multiple"
                                    autocomplete="off">
                                    @php
                                        $oldTags = old(
                                            'tags',
                                            $isEdit ? $product->tags->pluck('id')->toArray() ?? [] : [],
                                        );
                                    @endphp
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            {{ in_array($tag->id, $oldTags) ? 'selected' : '' }}>{{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tags')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="images-dropzone" class="form-label">Imágenes</label>
                                <div id="images-dropzone" class="dropzone"></div>
                                <small class="form-text text-muted">Puedes arrastrar y soltar varias imágenes.</small>
                                @if ($isEdit && $product->images && $product->images->count())
                                    <div class="mt-2">
                                        <span>Imágenes actuales:</span>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($product->images as $img)
                                                <div class="position-relative image-item"
                                                    data-image-id="{{ $img->id }}">
                                                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="Imagen"
                                                        width="80" class="img-thumbnail mb-1">
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger p-1 btn-delete-image"
                                                        title="Eliminar imagen" style="position:absolute;top:0;right:0;"
                                                        data-url="{{ route('admin.products.images.destroy', [$product->id, $img->id]) }}">
                                                        &times;
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @error('images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet" />
    @endpush
    @push('scripts')
        <!-- jQuery primero -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- Dropzone -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
        <script>
            $(function() {
                $('#tags').select2({
                    tags: true,
                    tokenSeparators: [',', ' '],
                    placeholder: 'Agrega tags',
                    width: '100%'
                });
            });
            // Inicializar Dropzone para imágenes
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone('#images-dropzone', {
                url: '#', // No se sube automáticamente, solo para frontend
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 10,
                maxFiles: 10,
                paramName: 'images',
                addRemoveLinks: true,
                acceptedFiles: 'image/*',
                dictDefaultMessage: 'Arrastra y suelta tus imágenes aquí o haz clic para seleccionar',
            });
            // Al enviar el formulario, agregar los archivos de Dropzone al FormData
            document.getElementById('product-form').addEventListener('submit', function(e) {
                if (myDropzone.getAcceptedFiles().length > 0) {
                    e.preventDefault();
                    var form = this;
                    var formData = new FormData(form);
                    myDropzone.getAcceptedFiles().forEach(function(file, i) {
                        formData.append('images[]', file, file.name);
                    });
                    // Enviar el formulario manualmente
                    fetch(form.action, {
                        method: form.method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    }).then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            return response.text();
                        }
                    }).then(data => {
                        if (data) {
                            document.open();
                            document.write(data);
                            document.close();
                        }
                    });
                }
            });
            // Eliminar imagen por AJAX
            $(document).on('click', '.btn-delete-image', function(e) {
                e.preventDefault();
                if (!confirm('¿Eliminar esta imagen?')) return;
                var btn = $(this);
                var url = btn.data('url');
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: $('input[name="_token"]').val()
                    },
                    success: function(resp) {
                        btn.closest('.image-item').fadeOut(300, function() {
                            $(this).remove();
                        });
                    },
                    error: function(xhr) {
                        alert('Error al eliminar la imagen.');
                    }
                });
            });
        </script>
    @endpush
@endsection
