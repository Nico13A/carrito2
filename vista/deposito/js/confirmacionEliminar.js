$(document).ready(function() {
    $('.eliminarProducto').on('click', function() {
        let idProducto = $(this).data('id');
        $('#eliminarModal').modal('show'); 
        $.ajax({
            url: 'accion/accionConfirmar.php',  
            method: 'POST',
            data: { idProducto: idProducto },
            success: function(response) {
                
                let producto = JSON.parse(response);
                $('#eliminar-nombre').text('Nombre: '+ producto.pronombre);
                $('#eliminar-image').attr('src', producto.urlimagen);
                $('#eliminar-details').text('Detalle: ' + producto.prodetalle);
                $('#eliminar-price').text('Precio: ' + producto.proprecio);
                $('#eliminar-stock').text('Stock: ' + producto.procantstock);
                $('#ideliminar').val(idProducto);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos del producto:', error);
            }
        });
    });
    
});
