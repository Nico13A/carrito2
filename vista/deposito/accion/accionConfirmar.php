<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
$idProducto = $datos['idProducto'];
$controProducto = new ABMProducto();
$producto = $controProducto->buscar(['idproducto' => $idProducto]);

$imagen=$producto[0]->getUrlImagen();
$url="../img/".$imagen;

if (count($producto) > 0) {
    $mostrarProducto = [
        'pronombre' => $producto[0]->getProNombre(),
        'prodetalle' => $producto[0]->getProDetalle(),
        'procantstock' => $producto[0]->getProCantStock(),
        'proprecio' => $producto[0]->getProPrecio(),
        'urlimagen' => $url
    ];
    echo json_encode($mostrarProducto);
} else {
    echo json_encode(['error' => 'Producto no encontrado']);
}

?>