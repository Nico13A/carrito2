<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
$idProducto = $datos['idProducto'];
$controProducto = new ABMProducto();
//$producto =$controProducto->buscar(['idproducto' => $idProducto]);

if ($controProducto->baja(['idproducto' => $idProducto])) {
    echo json_encode(['estado' => 'exito']);
} else {
    echo json_encode(['error' => 'No se puede eliminar eliminar el producto']);
}

?>