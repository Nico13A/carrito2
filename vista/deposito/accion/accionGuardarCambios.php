<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
$idProducto = $datos['idProducto'];

$controProducto = new ABMProducto();
$producto = $controProducto->buscar(['idproducto' => $idProducto]);

$imagen=$producto[0]->getUrlImagen();

$param=[
    'idproducto'=> $datos['idProducto'],
    'pronombre'=> $datos['nombre'],
    'prodetalle'=> $datos['detalle'],
    'procantstock'=> $datos['stock'],
    'proprecio'=> $datos['precio'],
    'urlimagen'=> $imagen 
];

if ($controProducto->modificacion($param)) {
    echo json_encode(['estado' => 'Se agrego actualizo correctamente']);
} else {
    echo json_encode(['error' => 'Producto no encontrado']);
}

?>