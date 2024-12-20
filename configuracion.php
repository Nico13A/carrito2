<?php

    header('Content-Type: text/html; charset=utf-8');
    header ("Cache-Control: no-cache, must-revalidate ");

    date_default_timezone_set('America/Argentina/Buenos_Aires');

    /////////////////////////////
    //    CONFIGURACION APP    //
    /////////////////////////////
    
    // Ubicacion de donde se encuentra el proyecto.
    $PROYECTO = 'carrito2';

    // Variable que almacena el directorio del proyecto.
    $ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

    include_once($ROOT . 'util/funciones.php');

    // Variable que define la pagina principal del proyecto (menu principal).
    $PRINCIPAL = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/vista/home/index.php";

    // Ruta base de las imágenes.
    $URLIMAGEN = "http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/vista/img/";

    $GLOBALS['ROOT'] = $ROOT;

?>