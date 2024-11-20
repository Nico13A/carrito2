$(document).ready(function() {
    $('#cambiar').on('click', function() {
        var idproducto = $('#idproducto').val();
        var stock = $('#product-stock').val();
        var precio = $('#product-price').val();
        var detalle = $('#product-details').val();
        var nombre = $('#product-nombre').val();
        $.ajax({
            url: 'accion/accionGuardarCambios.php',  
            method: 'POST',
            data: { idProducto: idproducto, stock: stock, precio: precio, detalle: detalle,nombre: nombre },
            success: function(response) {
                try {
                    let jsonResponse = JSON.parse(response);
                    if (jsonResponse.estado === 'exito') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Producto actualizado!',
                            text: 'El producto se actualizó correctamente.',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: jsonResponse.mensaje || 'Ocurrió un problema al actualizar el producto.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                } catch (e) {
                    console.error('Error al analizar JSON:', e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La respuesta del servidor no es válida.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos del producto:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema con la solicitud.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});
