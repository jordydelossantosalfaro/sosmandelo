@section('title', 'Productos')
@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">
                Productos
            </h2>
            <p>
                Aquí puedes administrar los productos de tu tienda. Puedes crear, editar, eliminar y exportar productos.
            </p>
        </div>
        <div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm rounded">
                Nuevo Producto
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
            @forelse ($products as $product)
                <article class="itemlist">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-sm-4 col-8 flex-grow-1 col-name">
                            <a class="itemside" href="{{ route('admin.products.summernote-standalone', $product->id) }}">
                                <div class="left">
                                    @if ($product->images && $product->images->count())
                                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                            class="img-sm img-thumbnail" alt="{{ $product->name }}" />
                                    @else
                                        <img src="{{ asset('imgs/items/1.jpg') }}" class="img-sm img-thumbnail"
                                            alt="No image" />
                                    @endif
                                </div>
                                <div class="info">
                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-4 col-price">
                            <span>S/.{{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-4 col-status">
                            <span class="badge rounded-pill alert-success">Activo</span>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-4 col-date">
                            <span>{{ $product->created_at->format('d.m.Y') }}</span>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-4 col-action text-end">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-xs btn-warning me-1"
                                title="Editar">
                                <i class="material-icons md-edit" style="font-size:16px;vertical-align:middle;"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-xs btn-danger btn-eliminar" title="Eliminar">
                                    <i class="material-icons md-delete" style="font-size:16px;vertical-align:middle;"></i>
                                </button>
                            </form>
                        </div>
                        @push('scripts')
                            <script>
                                // Eliminar producto por AJAX o con confirmación
                                $(document).on('click', '.btn-eliminar', function(e) {
                                    e.preventDefault();
                                    alert('No disponible');
                                });
                            </script>
                        @endpush
                    </div>
                </article>
            @empty
                <div class="text-center text-muted">No hay productos registrados.</div>
            @endforelse
        </div>
    </div>
    <div class="pagination-area mt-30 mb-50">
        {{ $products->links() }}
    </div>
@endsection
