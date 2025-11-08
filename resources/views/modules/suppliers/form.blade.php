@php
    $isEdit = isset($supplier);
@endphp
@section('title', $isEdit ? 'Editar Proveedor' : 'Crear Proveedor')
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="content-header mb-4">
                <h2 class="content-title">
                    {{ $isEdit ? 'Editar Proveedor' : 'Crear Proveedor' }}
                </h2>
                <div>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-light rounded font-sm mr-5 text-body hover-up">
                        Cancelar
                    </a>
                    <button type="submit" form="supplier-form" class="btn btn-md rounded font-sm hover-up">
                        Guardar
                    </button>
                </div>
            </div>
            <form id="supplier-form" method="POST"
                action="{{ $isEdit ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>
                                    Información del proveedor
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="document_type" class="form-label">Tipo documento</label>
                                        <select class="form-select" name="document_type" id="document_type">
                                            <option value="DNI"
                                                {{ old('document_type', $isEdit ? $supplier->document_type : null) == 'DNI' ? 'selected' : '' }}>
                                                DNI</option>
                                            <option value="RUC"
                                                {{ old('document_type', $isEdit ? $supplier->document_type : null) == 'RUC' ? 'selected' : '' }}>
                                                RUC</option>
                                        </select>
                                        @error('document_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="document_number" class="form-label">Nro. Documento</label>
                                        <input type="text" class="form-control" name="document_number"
                                            id="document_number"
                                            value="{{ old('document_number', $isEdit ? $supplier->document_number : null) }}"
                                            {{ $isEdit ? 'readonly' : '' }} />
                                        @error('document_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $isEdit ? $supplier->name : null) }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>
                                    Contacto
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="phone1" class="form-label">Celular 1</label>
                                        <input type="text" class="form-control" name="phone1" id="phone1"
                                            value="{{ old('phone1', $isEdit ? $supplier->phone1 : null) }}" />
                                        @error('phone1')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="phone2" class="form-label">Celular 2</label>
                                        <input type="text" class="form-control" name="phone2" id="phone2"
                                            value="{{ old('phone2', $isEdit ? $supplier->phone2 : null) }}" />
                                        @error('phone2')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="whatsapp" class="form-label">Nro. WhatsApp</label>
                                        <input type="text" class="form-control" name="whatsapp" id="whatsapp"
                                            value="{{ old('whatsapp', $isEdit ? $supplier->whatsapp : null) }}" />
                                        @error('whatsapp')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Correo</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ old('email', $isEdit ? $supplier->email : null) }}" />
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>
                                    Más información
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="opening_time" class="form-label">Horario de apertura</label>
                                    <input type="time" class="form-control" name="opening_time" id="opening_time"
                                        value="{{ old('opening_time', $isEdit ? $supplier->opening_time : null) }}" />
                                    @error('opening_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="closing_time" class="form-label">Horario de cierre</label>
                                    <input type="time" class="form-control" name="closing_time" id="closing_time"
                                        value="{{ old('closing_time', $isEdit ? $supplier->closing_time : null) }}" />
                                    @error('closing_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Días de atención</label>
                                    @php
                                        $diasAtencion = old('dias_atencion');
                                        if ($isEdit && is_null($diasAtencion)) {
                                            $diasAtencion = $supplier->working_days
                                                ? json_decode($supplier->working_days, true)
                                                : [];
                                        }
                                    @endphp
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="dias_atencion[]"
                                            id="monday" value="Monday"
                                            {{ is_array($diasAtencion) && in_array('Monday', $diasAtencion) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="monday">Lunes</label>
                                    </div>
                                    @error('dias_atencion')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="dias_atencion[]"
                                            id="tuesday" value="Tuesday"
                                            {{ is_array($diasAtencion) && in_array('Tuesday', $diasAtencion) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tuesday">Martes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="dias_atencion[]"
                                            id="wednesday" value="Wednesday"
                                            {{ is_array($diasAtencion) && in_array('Wednesday', $diasAtencion) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wednesday">Miercoles</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="dias_atencion[]"
                                            id="thursday" value="Thursday"
                                            {{ is_array($diasAtencion) && in_array('Thursday', $diasAtencion) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="thursday">Jueves</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="dias_atencion[]"
                                            id="friday" value="Friday"
                                            {{ is_array($diasAtencion) && in_array('Friday', $diasAtencion) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="friday">Viernes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="dias_atencion[]"
                                            id="saturday" value="Saturday"
                                            {{ is_array($diasAtencion) && in_array('Saturday', $diasAtencion) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="saturday">Sabado</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="dias_atencion[]"
                                            id="sunday" value="Sunday"
                                            {{ is_array($diasAtencion) && in_array('Sunday', $diasAtencion) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sunday">Domingo</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_category" class="form-label">
                                        Categoría de proveedor
                                    </label>
                                    @php
                                        $selectedCategories = old('supplier_category');
                                        if ($isEdit && is_null($selectedCategories) && isset($selected_categories)) {
                                            $selectedCategories = $selected_categories;
                                        }
                                    @endphp
                                    <select name="supplier_category[]" id="supplier_category" multiple>
                                        @foreach ($supplier_categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ is_array($selectedCategories) && in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_category')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">Subir archivo</label>
                                    <input class="form-control" type="file" name="file" id="file" />
                                    @if ($isEdit && $supplier->image)
                                        <div class="mt-2">
                                            <span>Archivo actual:</span>
                                            <a href="{{ asset('storage/' . $supplier->image) }}" target="_blank">Ver
                                                archivo</a>
                                        </div>
                                    @endif
                                    @error('file')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Estado</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="Active"
                                            {{ old('status', $isEdit ? ucfirst($supplier->status) : null) == 'Active' ? 'selected' : '' }}>
                                            Activo</option>
                                        <option value="Inactive"
                                            {{ old('status', $isEdit ? ucfirst($supplier->status) : null) == 'Inactive' ? 'selected' : '' }}>
                                            Inactivo</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>
                                    Información comercial
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="business_name" class="form-label">Nombre comercial</label>
                                    <input type="text" class="form-control" name="business_name" id="business_name"
                                        value="{{ old('business_name', $isEdit ? $supplier->business_name : null) }}" />
                                    @error('business_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        value="{{ old('address', $isEdit ? $supplier->address : null) }}" />
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ubicación</label>
                                    <input id="map-search" class="form-control mb-2" type="text"
                                        placeholder="Buscar negocios o direcciones en Google Maps...">
                                    <div id="map" style="width:100%;height:300px;border:1px solid #ddd;"></div>
                                    <input type="hidden" name="latitude" id="latitude"
                                        value="{{ old('latitude', $isEdit ? $supplier->latitude : null) }}">
                                    <input type="hidden" name="longitude" id="longitude"
                                        value="{{ old('longitude', $isEdit ? $supplier->longitude : null) }}">
                                    @error('latitude')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('longitude')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#supplier_category').select2({
                width: '100%',
                placeholder: 'Selecciona familia',
                allowClear: true
            });
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwlQA-YsZz4CfjdDqR4ZDObEeTQ5PvIgs&libraries=places">
    </script>
    <script>
        let map, marker, autocomplete;

        function initMap() {
            const defaultLat = parseFloat(document.getElementById('latitude').value) || -12.0464; // Lima, Peru
            const defaultLng = parseFloat(document.getElementById('longitude').value) || -77.0428;
            const defaultPosition = {
                lat: defaultLat,
                lng: defaultLng
            };
            map = new google.maps.Map(document.getElementById('map'), {
                center: defaultPosition,
                zoom: 15
            });
            marker = new google.maps.Marker({
                position: defaultPosition,
                map: map,
                draggable: true
            });
            // Update hidden fields
            function updateLatLngFields(lat, lng) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            }
            // Marker drag event
            marker.addListener('dragend', function(event) {
                updateLatLngFields(event.latLng.lat(), event.latLng.lng());
            });
            // Map click event
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                updateLatLngFields(event.latLng.lat(), event.latLng.lng());
            });
            // Autocomplete for businesses and addresses
            const input = document.getElementById('map-search');
            autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['establishment', 'geocode'],
                fields: ['place_id', 'geometry', 'name', 'formatted_address']
            });
            autocomplete.bindTo('bounds', map);
            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (!place.geometry) return;
                map.panTo(place.geometry.location);
                map.setZoom(17);
                marker.setPosition(place.geometry.location);
                updateLatLngFields(place.geometry.location.lat(), place.geometry.location.lng());
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof google !== 'undefined') {
                initMap();
            } else {
                // If Google Maps script hasn't loaded yet
                let interval = setInterval(function() {
                    if (typeof google !== 'undefined') {
                        clearInterval(interval);
                        initMap();
                    }
                }, 500);
            }
        });
    </script>
@endpush
