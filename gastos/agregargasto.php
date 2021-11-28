<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $descripcion = $_POST['descripcion'];
    $valor = $_POST['valor'];
    $encargado = $_POST['encargado'];
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipogasto'];
    //consulta ruta del encargado 
    $consultaruta = "select id_ruta from rutas where encargado = $encargado";
    echo $query1 = mysqli_query($link, $consultaruta) or die($consultaruta);
    $filas1 = mysqli_fetch_array($query1);
    $ruta = $filas1['id_ruta'];
    //consultar insertar
    $consulta = "INSERT INTO `gastos`(`id_gasto`, `descripcion`, `ruta`, `encargado`, `fecha`, `valor`,`tipo`) VALUES "
            . "('','$descripcion','$ruta','$encargado','$fecha','$valor','$tipo')";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
    //$consultarestacajamenor = "UPDATE `rutas` SET `base`=base - $valor WHERE id_ruta=$ruta";
    //echo $query = mysqli_query($link, $consultarestacajamenor) or die($consultarestacajamenor);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
