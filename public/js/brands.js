$(document).ready(function() {
    const tabla = $('#brands-table').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: '/js/es-ES.json'
        },
        ajax: $('#brands-table').data('url'),
        columns: [
            { data: 'id', title: 'ID' },
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
                    $('#form-marca')[0].reset();
                    $('#brand_id').val('');
                    $('#btn-submit').text('Crear marca');
                    modo = 'crear';
                    idEditar = null;
                    $('#brand_name').focus();
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

    tabla.buttons().each(function(btn, i) {
        const html = $(tabla.button(i).node()).html();
        $(tabla.button(i).node()).html(html);
    });

    let modo = 'crear';
    let idEditar = null;

    // CSRF token para todas las peticiones AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Envío del formulario por AJAX
    $('#form-marca').on('submit', function(e) {
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
            msgSuccess = 'Marca creada correctamente';
        } else {
            url = `/brands/${idEditar}`;
            method = 'POST';
            formData += '&_method=PUT';
            msgSuccess = 'Marca actualizada correctamente';
        }
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                form[0].reset();
                $('#brand_id').val('');
                $('#btn-submit').text('Crear marca');
                modo = 'crear';
                idEditar = null;
                tabla.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: msgSuccess,
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(xhr) {
                let msg = 'Error al guardar la marca';
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

    // Click en editar
    $(document).on('click', '.btn-editar', function() {
        const id = $(this).data('id');
        $.get(`/brands/${id}`, function(data) {
            $('#brand_id').val(data.id);
            $('#brand_name').val(data.name);
            $('#brand_status').val(data.status);
            $('#btn-submit').text('Actualizar marca');
            modo = 'editar';
            idEditar = data.id;
        });
    });

    // Click en eliminar
    $(document).on('click', '.btn-eliminar-marca', function() {
        Swal.fire({
            title: '¿Estás seguro de que deseas eliminar esta marca?',
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
                url: `/brands/${id}`,
                method: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    tabla.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Marca eliminada correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al eliminar la marca',
                        showConfirmButton: true
                    });
                }
            });
        });
    });
});
