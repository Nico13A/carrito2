$(document).ready(function () {
    $('#Eliminar').on('click', function(){
        var idproductoEliminar = $('#ideliminar').val();
        $.ajax({
            url: 'accion/accionEliminarProducto.php',  
            method: 'POST',
            data: { idProducto: idproductoEliminar },
            success: function(response) {
                    let jsonResponse = JSON.parse(response);
                    if (jsonResponse.estado === 'exito') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Producto Eliminado!',
                            text: 'El producto se Elimino correctamente.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => { 
                            setTimeout(() => { 
                                $('#eliminarModal').modal('hide'); }, 1200);
                            });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: jsonResponse.mensaje || 'Ocurrió un problema al Eliminar el producto.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos del producto:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Verifique si esta pedido antes de eliminar.',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
    })
})