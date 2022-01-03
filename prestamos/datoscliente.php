<?php

session_start();
if ($_SESSION['usuario']) {
    include_once('../conexion/conexion.php');
    include_once('../prestamos/funciones.php');

    $obj = new prestamos();
    echo json_encode($obj->obtenerdatoscliente($_POST['cliente']));
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
