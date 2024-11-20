<?php
include_once "../../../configuracion.php";

// Iniciar la sesión
$objSession = new Session();

// Verificar si el usuario está logueado
if ($objSession->validar()) {
    // Obtener el usuario logueado
    $objUsuario = $objSession->getUsuario();
    $idUsuario = $objUsuario->getIdUsuario();

    // Buscar todas las compras del usuario
    $controlCompra = new AbmCompra();
    $compras = $controlCompra->buscar(['idusuario' => $idUsuario]);

    // Verificar si se encontraron compras
    if (count($compras) > 0) {
        $carritos = [];

        // Recorrer las compras del usuario
        foreach ($compras as $compra) {
            $idCompra = $compra->getIdCompra();

            // Buscar el estado de la compra para asegurarnos de que está en 'carrito'
            $controlCompraEstado = new ABMCompraEstado();
            $estadoCompra = $controlCompraEstado->buscar(['idcompra' => $idCompra]);

            // Verificar si el estado de la compra es 'carrito'
            if (count($estadoCompra) > 0 && $estadoCompra[0]->getObjCompraEstadoTipo()->getCetDescripcion() == 'carrito') {
                // Obtener el idCompraEstado asociado al carrito
                $idCompraEstado = $estadoCompra[0]->getIdCompraEstado();

                // Buscar los productos en el carrito utilizando el idCompra
                $controlCompraItem = new AbmCompraItem();
                $itemsCarrito = $controlCompraItem->buscar(['idcompra' => $idCompra]);

                // Verificar si el carrito tiene productos
                if (count($itemsCarrito) > 0) {
                    $productos = [];

                    foreach ($itemsCarrito as $item) {
                        $producto = $item->getObjProducto();
                        $productos[] = [
                            'idproducto' => $producto->getIdProducto(),
                            'nombre' => $producto->getProNombre(),
                            'precio' => $producto->getProPrecio(),
                            'cantidad' => $item->getCiCantidad(),
                            'imagen' => $URLIMAGEN . $producto->getUrlImagen()
                        ];
                    }

                    // Agregar los productos y el idCompraEstado al carrito
                    $carritos[] = [
                        'idcompra' => $idCompra,
                        'idcompraestado' => $idCompraEstado,
                        'productos' => $productos
                    ];
                }
            }
        }

        // Verificar si se encontraron carritos
        if (count($carritos) > 0) {
            // Responder con los carritos y sus productos
            echo json_encode([
                'estado' => 'exito',
                'carritos' => $carritos
            ]);
        } else {
            // Si no se encontraron productos en ningún carrito
            echo json_encode(['estado' => 'error', 'mensaje' => 'Carrito vacío.']);
        }
    } else {
        // Si no se encuentran compras para el usuario
        echo json_encode(['estado' => 'error', 'mensaje' => 'No hay compras para este usuario.']);
    }
} else {
    // Si el usuario no está logueado
    echo json_encode(['estado' => 'error', 'mensaje' => 'Usuario no logueado.']);
}


?>