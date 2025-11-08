document.addEventListener('DOMContentLoaded', function () {
    const table = $('#subcategories-table').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: '/js/es-ES.json'
        },
        ajax: $('#subcategories-table').data('url'),
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'category', title: 'Categoría' },
            { data: 'name', title: 'Nombre' },
            { data: 'status', title: 'Estado' },
            { data: 'acciones', title: 'Acciones', orderable: false, searchable: false, className: 'text-end' }
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Nuevo',
                className: 'btn btn-success',
                action: function () {
                    $('#form-subcategoria')[0].reset();
                    $('#subcategory_id').val('');
                    $('#btn-submit').text('Crear subcategoría');
                    modo = 'crear';
                    idEditar = null;
                    $('#subcategory_name').focus();
                }
            },
            {
                extend: 'excel',
                text: 'Exportar a Excel',
                className: 'btn btn-outline-success'
            },
            {
                extend: 'pdf',
                text: 'Exportar a PDF',
                className: 'btn btn-outline-danger'
            }
        ]
    });

    table.buttons().each(function(btn, i) {
        const html = $(table.button(i).node()).html();
        $(table.button(i).node()).html(html);
    });

    // Modo: crear o editar
    let modo = 'crear';
    let idEditar = null;

    // CSRF token para todas las peticiones AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Form submit
    $('#form-subcategoria').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        let url = '';
        let method = '';
        let msgSuccess = '';
        let formData = form.serialize();
        const $btn = $('#btn-submit');
        $btn.prop('disabled', true);
        if (modo === 'crear') {
            url = form.data('store-url');
            method = 'POST';
            msgSuccess = 'Subcategoría creada correctamente';
        } else {
            url = `/subcategories/${idEditar}`;
            method = 'POST';
            formData += '&_method=PUT';
            msgSuccess = 'Subcategoría actualizada correctamente';
        }
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                form[0].reset();
                $('#subcategory_id').val('');
                $('#btn-submit').text('Crear subcategoría');
                modo = 'crear';
                idEditar = null;
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: msgSuccess,
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(xhr) {
                let msg = 'Error al guardar la subcategoría';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: msg,
                    showConfirmButton: true
                });
            },
            complete: function() {
                $btn.prop('disabled', false);
            }
        });
    });

    // Edit button
    $('#subcategories-table').on('click', '.btn-editar', function () {
        const id = $(this).data('id');
        $.get(`/subcategories/${id}`, function (data) {
            $('#subcategory_id').val(data.id);
            $('#subcategory_name').val(data.name);
            $('#subcategory_status').val(data.status);
            $('#subcategory_category_id').val(data.category_id);
            $('#btn-submit').text('Actualizar subcategoría');
            modo = 'editar';
            idEditar = data.id;
        });
    });

    // Delete button
    $('#subcategories-table').on('click', '.btn-eliminar-subcategoria', function () {
        Swal.fire({
            title: '¿Estás seguro de que deseas eliminar esta subcategoría?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) return;
            const id = $(this).data('id');
            $.ajax({
                url: `/subcategories/${id}`,
                method: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Subcategoría eliminada correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al eliminar la subcategoría',
                        showConfirmButton: true
                    });
                }
            });
        });
    });
});
