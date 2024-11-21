<?php
include_once("../../../configuracion.php");

$dir = '../../img/';

if ($_FILES['imagenProducto']["error"] <= 0) {
    if (copy($_FILES['imagenProducto']['tmp_name'], $dir . $_FILES['imagenProducto']['name'])) {
        $datos = [
            'estado' => 'exito',
            'nombre' => $_FILES['imagenProducto']['name'],
            'url' => '../img/' . $_FILES['imagenProducto']['name'],
            'nombreUrl' => $_FILES['imagenProducto']['name'] //agregar nombre para imagen
        ];
        echo json_encode($datos);
    } else {
        echo json_encode(['error' => 'no se pudo cargar el archivo']);
    }
} else {
    echo json_encode(['error' => 'el archivo esta vacio']);
}
?>
