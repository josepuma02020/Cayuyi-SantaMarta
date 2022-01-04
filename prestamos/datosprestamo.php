<?php

session_start();
if ($_SESSION['usuario']) {
    include_once('../conexion/conexion.php');
    include_once('../prestamos/funciones.php');

    $obj = new prestamos();
    echo json_encode($obj->obtenerdatosprestamo($_POST['id']));
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>


