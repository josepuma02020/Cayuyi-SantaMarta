<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['idu'];
    $recoger = $_POST['recoger'];
    $fecha_actual = date("Y-m-j");
    $consulta = "select valorapagar/dias_prestamo 'cuota',(valorapagar-abonado)-$recoger 'debe',ruta from prestamos where id_prestamo=$id ";
    $query = mysqli_query($link, $consulta) or die($consulta);
    $filas1 = mysqli_fetch_array($query);
    $resta = number_format(($recoger / $filas1['cuota']) - 1);
    if ($recoger == 0) {
        $consulta = "update prestamos set dias_atraso = dias_atraso + 1 where id_prestamo=$id ";
        $query = mysqli_query($link, $consulta) or die($consulta);
    } else {
        $consulta = "update prestamos set dias_atraso = dias_atraso - $resta where id_prestamo=$id ";
        $query = mysqli_query($link, $consulta) or die($consulta);
        $consulta = "update prestamos set abonado = abonado + $recoger where id_prestamo=$id ";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
    //ingresar registro
    $consultaatraso = "select dias_atraso,fecha,dias_prestamo from prestamos where id_prestamo=$id ";
    $query1 = mysqli_query($link, $consultaatraso) or die($consultaatraso);
    $filas2 = mysqli_fetch_array($query1);
    $atraso = $filas2['dias_atraso'];
    $diasprestamo = $filas2['dias_prestamo'];
    $diasprestamo--;
    echo 'vence:' . $fechavence = date("Y-m-d", strtotime($filas2['fecha'] . "+ " . $diasprestamo . "days"));
    $dateDifference = abs(strtotime($fecha_actual) - strtotime($fechavence));
    $years = floor($dateDifference / (365 * 60 * 60 * 24));
    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    echo 'dias' . $diascuota = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    $consulta = "INSERT INTO `registros_cuota`(`id_registro`, `prestamo`, `cuota`, `fecha`,saldo,atraso,diasvence) VALUES "
            . "('',$id,$recoger,'$fecha_actual','$filas1[debe]','$atraso','$diascuota') ";
    $query = mysqli_query($link, $consulta) or die($consulta);
    //estadodeprestamo
    $consulta = "select (valorapagar-abonado)'debe' from prestamos where id_prestamo=$id ";
    $query = mysqli_query($link, $consulta) or die($consulta);
    $filas1 = mysqli_fetch_array($query);
    if ($filas1['debe'] == 0) {
        $consulta = "update prestamos set fechacierre = '$fecha_actual' where id_prestamo=$id ";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
