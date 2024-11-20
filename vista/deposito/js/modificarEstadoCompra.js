$(document).ready(function () {
    // Muestra el modal cuando se hace clic en el botón de modificar
    $('.btnModificar').click(function () {
        const id = $(this).data('idcompraestado'); 
        $('#idcompraEstado').val(id);
        $('#modalModificar').modal('show'); 
    });

    // Enviar el formulario de modificación
    $('#formModificarEstadoCompra').submit(function (e) {
        e.preventDefault();  

        const idcompraestado = $('#idcompraEstado').val();
        const cetdescripcion = $('#cetdescripcion').val();

        $.ajax({
            url: 'accion/procesarEstadoCompra.php',  
            method: 'POST',
            data: { idcompraestado, cetdescripcion },
            success: function (response) {
                const result = JSON.parse(response); 

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: result.message || 'El estado de la compra se modificó correctamente.',
                    }).then(() => {
                        $('#modalModificar').modal('hide');  
                        location.reload();  
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: result.message
                    });
                }
            },
            error: function () {
                // Si hubo un error en la solicitud AJAX
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Hubo un error al procesar la solicitud.',
                });
            }
        });
    });
});

