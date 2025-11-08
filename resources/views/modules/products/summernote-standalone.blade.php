<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Demo Summernote Standalone</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            padding: 40px;
        }

        .note-editor.note-frame {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .note-toolbar {
            background: #fff;
        }

        .note-editable {
            min-height: 120px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-xl-12">
                <div class="card shadow p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0 text-primary">
                            <i class="material-icons align-middle">edit</i> {{ $product->name }}
                            <span class="text-muted small">- Editor de descripción</span>
                        </h4>
                    </div>
                    <form id="summernote-form" method="POST"
                        action="{{ route('products.summernote.update', $product->id) }}">
                        @csrf
                        @method('PUT')
                        <textarea class="summernote" id="summernote-demo" name="description">{{ old('description', $product->description ?? '') }}</textarea>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="material-icons align-middle">arrow_back</i> Regresar
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="material-icons align-middle">save</i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script>
        $(function() {
            $('#summernote-demo').summernote({
                height: 450,
                lang: 'es-ES',
                placeholder: 'Escribe la descripción del producto aquí...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear', 'strikethrough', 'superscript',
                        'subscript'
                    ]],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
</body>

</html>
