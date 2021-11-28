<?php

session_start();
if ($_SESSION['usuario']) {
    include_once('../conexion/conexion.php');
    include_once('../funciones/funciones.php');

    $obj = new prestamos();
    echo json_encode($obj->baseruta($_POST['id']));
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>

