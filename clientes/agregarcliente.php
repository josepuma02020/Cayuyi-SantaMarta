<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $consulta = "INSERT INTO `clientes`(`id_cliente`, `nombre`, `cedula`, `telefono`, `direccion`) VALUES "
        . "('','$nombre','$cedula','$telefono','$direccion') ";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
