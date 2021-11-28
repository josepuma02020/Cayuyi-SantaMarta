<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $valor = $_POST['valorretiro'];
    $ruta = $_POST['ruta'];
    $tipo = $_POST['tipo'];
    $comentario = $_POST['comentario'];
    $fecha_actual = date("Y-m-j");
    //base
    if ($tipo == 1) {
        $consultabase = "UPDATE `rutas` SET `base`=base - $valor WHERE id_ruta = $ruta";
    } else {
        $consultabase = "UPDATE `rutas` SET `base`=base + $valor WHERE id_ruta = $ruta";
    }
    echo $query = mysqli_query($link, $consultabase) or die($consultabase);
    //registrar
    $consultaregistro="INSERT INTO `transacciones`(`id_movimiento`, `tipo`, `ruta`, `valor`, `fecha`, `comentario`) VALUES "
            . "('',$tipo,$ruta,$valor,'$fecha_actual','$comentario')";
    echo $query = mysqli_query($link, $consultaregistro) or die($consultaregistro);
}else{
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
