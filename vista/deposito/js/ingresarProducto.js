$(document).ready(function() {
    $('#agregarProducto').on('click', function(){
        var url = $('#urlImagen').val();
        var nombre = $('#nombreProducto').val();
        var precio = $('#precioProducto').val();
        var descripcion = $('#descripcionProducto').val();
        var cantidad = $('#cantProducto').val();
        $.ajax({
            url: 'accion/accionSubirProducto.php',  
            method: 'POST',
            data: { url: url, nombre: nombre, precio: precio, descripcion: descripcion, cantidad: cantidad },
            success: function(response){
                console.log(response);
                try {
                    let jsonResponse = JSON.parse(response);
                    console.log(jsonResponse);
                    if (jsonResponse.estado === 'exito') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Producto fue agregado!',
                            text: 'El producto se agregó correctamente.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => { 
                            setTimeout(() => { 
                                $('#agregarModal').modal('hide'); 
                            }, 1200);
                        });
                        $('#nombreProducto').val("");
                        $('#descripcionProducto').val("");
                        $('#precioProducto').val("");
                        $('#cantProducto').val("");
                        $('#imagenPrevisualizada').attr('src', '').css('display', 'none');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: jsonResponse.mensaje || 'Ocurrió un problema al agregar el producto.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                } catch (e) {
                    console.error('La respuesta no es un JSON válido:', e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La respuesta del servidor no es un JSON válido.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', error);
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
