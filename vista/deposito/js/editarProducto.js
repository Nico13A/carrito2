$(document).ready(function() {
    $('.editarProducto').on('click', function() {
        let idProducto = $(this).data('id');
        $('#productoModal').modal('show'); 
        $.ajax({
            url: 'accion/accionEditar.php',  
            method: 'POST',
            data: { idProducto: idProducto },
            success: function(response) {
                let producto = JSON.parse(response);
                $('#product-nombre').val(producto.pronombre);
                $('#product-image').attr('src', producto.urlimagen);
                $('#product-details').val(producto.prodetalle);
                $('#product-price').val(producto.proprecio);
                $('#product-stock').val(producto.procantstock);
                $('#idproducto').val(idProducto);


            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos del producto:', error);
            }
        });
    });
    
});
