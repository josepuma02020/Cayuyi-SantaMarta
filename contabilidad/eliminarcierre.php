<?php
session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['id'];
    $consultaefecivo_ = "select efectivo,ruta from revisionesrutas where idhistorial=$id";
    $queryefectivo = mysqli_query($link, $consultaefecivo_) or die($consultaefecivo_);
    $filaefectivo = mysqli_fetch_array($queryefectivo);

    $consultadescuentobase = "UPDATE `rutas` SET `base`=base - $filaefectivo[efectivo]  WHERE `id_ruta` = $filaefectivo[ruta]";
    $queryedescuentobase = mysqli_query($link, $consultadescuentobase) or die($consultadescuentobase);

    $consulta = "DELETE FROM `revisionesrutas` WHERE idhistorial = $id";
    $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
