<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $nombre = $_POST['nombre'];
    $encargado = $_POST['encargado'];
    //consultar por producto
    $consulta = "INSERT INTO `rutas`(`id_ruta`, `ruta`, `encargado`) VALUES ('','$nombre','$encargado') ";
   echo $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
