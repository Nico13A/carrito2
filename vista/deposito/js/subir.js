$(document).ready(function () {
    $('#subirImagen').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData();
        var file = $('#imagenProducto')[0].files[0]; 
        formData.append('imagenProducto', file);
        $.ajax({
            url: './accion/accionSubirArchivo.php', 
            type: 'POST',
            data: formData,
            contentType: false, 
            processData: false,
            success: function (response){
                let jsonResponse = JSON.parse(response);
                if (jsonResponse.estado === 'exito') {
                    $('#imagenPrevisualizada').attr('src', jsonResponse.url).show();
                    $('#urlImagen').val(jsonResponse.nombreUrl);
                } else {
                    alert('Error: ' + jsonResponse.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('Error uploading image');
            }
        });
    });
});
