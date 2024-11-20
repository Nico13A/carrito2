<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
$response = [
    'success' => false,
    'message' => 'Ocurrió un error inesperado.',
];

// Verificar si se recibió el ID del estado de compra y la descripción del nuevo estado
if (isset($datos['idcompraestado']) && isset($datos['cetdescripcion'])) {
    $idCompraEstado = $datos['idcompraestado'];
    $cetDescripcion = $datos['cetdescripcion'];

    $objCompraEstado = new ABMCompraEstado();
    $objCompraEstadoTipo = new ABMCompraEstadoTipo();
    $objCompraItem = new ABMCompraItem();
    $objProducto = new ABMProducto();

    // Buscar el estado de compra
    $estadoCompra = $objCompraEstado->buscar(['idcompraestado' => $idCompraEstado])[0] ?? null;

    if ($estadoCompra) {
        // Obtener datos del estado actual
        $idCompra = $estadoCompra->getObjCompra()->getIdCompra();
        $idCompraEstadoTipoAnterior = $estadoCompra->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
        $ceFechaIni = $estadoCompra->getCeFechaIni();

        // Verificar si el estado actual es "cancelado" (ID = 4)
        if ($idCompraEstadoTipoAnterior == 4) {
            // Si está cancelada, no se puede modificar
            $response['message'] = 'La compra ya ha sido cancelada y no puede ser reactivada ni modificada.';
        } else {
            // Obtener el nuevo estado tipo a partir de la descripción
            $compraEstadoTipo = $objCompraEstadoTipo->buscar(['cetdescripcion' => $cetDescripcion])[0] ?? null;

            if ($compraEstadoTipo) {
                $idCompraEstadoTipoActualizado = $compraEstadoTipo->getIdCompraEstadoTipo();
                $fechaActual = (new DateTime())->format('Y-m-d H:i:s');

                // Parámetros para modificar el estado anterior
                $paramEstadoCompraAnterior = [
                    "idcompraestado" => $idCompraEstado,
                    "idcompra" => $idCompra,
                    "idcompraestadotipo" => $idCompraEstadoTipoAnterior,
                    "cefechaini" => $ceFechaIni,
                    "cefechafin" => $fechaActual,
                ];

                // Parámetros para el nuevo estado
                $paramEstadoCompraNuevo = [
                    "idcompra" => $idCompra,
                    "idcompraestadotipo" => $idCompraEstadoTipoActualizado,
                    "cefechaini" => $fechaActual,
                    "cefechafin" => null,
                ];

                // Modificar el estado anterior y agregar el nuevo estado
                if ($objCompraEstado->modificacion($paramEstadoCompraAnterior) && $objCompraEstado->alta($paramEstadoCompraNuevo)) {
                    // Si el nuevo estado es "cancelado" (ID == 4), se debe actualizar el stock
                    if ($idCompraEstadoTipoActualizado == 4) {
                        $arrayCompraItem = $objCompraItem->buscar(["idcompra" => $idCompra]);
                        foreach ($arrayCompraItem as $compraItem) {
                            $producto = $compraItem->getObjProducto();
                            $paramProducto = [
                                "idproducto" => $producto->getIdProducto(),
                                "pronombre" => $producto->getProNombre(),
                                "prodetalle" => $producto->getProDetalle(),
                                "procantstock" => $producto->getProCantStock() + $compraItem->getCiCantidad(),
                                "proprecio" => $producto->getProPrecio(),
                                "urlimagen" => $producto->getUrlImagen(),
                            ];
                            $objProducto->modificacion($paramProducto); // Actualizar stock del producto
                        }
                    }

                    // Responder con éxito
                    $response = [
                        'success' => true,
                        'message' => 'El estado de la compra fue modificado exitosamente.',
                    ];
                } else {
                    $response['message'] = 'No se pudo modificar el estado de la compra.';
                }
            } else {
                $response['message'] = 'El tipo de estado especificado no es válido.';
            }
        }
    } else {
        $response['message'] = 'No se encontró el registro de estado de compra con el ID proporcionado.';
    }
} else {
    $response['message'] = 'Faltan datos requeridos para procesar la solicitud.';
}

// Responder con JSON
echo json_encode($response);
?>

