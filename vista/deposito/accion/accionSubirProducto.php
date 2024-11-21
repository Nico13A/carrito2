<?php
include_once("../../../configuracion.php");

$datos=data_submitted();

$controProducto= new ABMProducto();
$param=[
    'pronombre' =>$datos['nombre'],
    'prodetalle' =>$datos['descripcion'],
    'procantstock' =>$datos['cantidad'],
    'proprecio' =>$datos['precio'],
    'urlimagen' =>$datos['url'],
];
if ($controProducto->alta($param)){
    echo json_encode(['estado' => 'exito']);
}
else{
    echo json_encode(['error' => 'no se pudo agregar el producto']);
}
?>
