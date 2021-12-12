<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $direccion = $_POST['telefono'];
    $telefono = $_POST['telefono'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];
    $claveh = password_hash($clave, PASSWORD_DEFAULT);
    if($rol != "0"){
        echo "aqui";
        $consulta = "UPDATE `usuarios` SET `rol`='$rol' WHERE id_usuario = $id ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
