<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $encargado = $_POST['encargado'];
    if ($nombre == "") {
        if ($encargado != 0) {
          $consulta = "UPDATE `rutas` SET `encargado`=$encargado WHERE id_ruta = $id";
        }
    } else {
        if ($encargado == 0) {
            $consulta = "UPDATE `rutas` SET `ruta`='$nombre' WHERE id_ruta = $id ";
        } else {
            $consulta = "UPDATE `rutas` SET ``ruta`='$nombre',`encargado`=$encargado WHERE id_ruta = $id";
        }
    }



    echo $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
