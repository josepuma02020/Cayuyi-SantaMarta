<?php

session_start();
if ($_SESSION['usuario']) {
    include_once('../conexion/conexion.php');
    include_once('../usuarios/funcionesusuarios.php');

    $obj = new usuarios();
    echo json_encode($obj->obtenerdatosusuario($_POST['id']));
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
