$.ajax({
    url: 'accion/accionSubirProducto.php',  
    method: 'POST',
    data: { url: url, nombre: nombre, precio: precio, descripcion: descripcion, cantidad: cantidad },
    success: function(response){
        console.log(response);
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
                        $('#agregarModal').modal('hide'); }, 1100);
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
    },
    error: function(xhr, status, error) {
        console.log(response);
        console.error('Error en la solicitud:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un problema con la solicitud.',
            confirmButtonText: 'Aceptar'
        });
    }
});
