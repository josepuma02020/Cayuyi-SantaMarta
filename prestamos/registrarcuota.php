<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $id = $_POST['idu'];
    $recoger = $_POST['recoger'];
    $fecha = $_POST['fecha'];
    $fecha_actual = date("Y-m-j");
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $consulta = "select valorapagar/dias_prestamo 'cuota',(valorapagar-abonado)-$recoger 'debe',ruta,valorapagar from prestamos where id_prestamo=$id ";
    $query = mysqli_query($link, $consulta) or die($consulta);
    $filas1 = mysqli_fetch_array($query);
    echo $consultaverificarcuota = "SELECT * FROM `registros_cuota` WHERE fecha = '$fecha' and prestamo = $id and liquidado != 2 ";
    $queryverificar = mysqli_query($link, $consultaverificarcuota) or die($consultaverificarcuota);
    $filasverificar = mysqli_fetch_array($queryverificar);
    //ingresar registro
    $consultaatraso = "select dias_atraso,fecha,dias_prestamo from prestamos where id_prestamo=$id ";
    $query1 = mysqli_query($link, $consultaatraso) or die($consultaatraso);
    $filas2 = mysqli_fetch_array($query1);
    $atraso = $filas2['dias_atraso'] + 1;
    $diasprestamo = $filas2['dias_prestamo'];
    $diasprestamo--;
    'vence:' . $fechavence = date("Y-m-d", strtotime($filas2['fecha'] . "+ " . $diasprestamo . "days"));
    $dateDifference = abs(strtotime($fecha_actual) - strtotime($fechavence));
    $years = floor($dateDifference / (365 * 60 * 60 * 24));
    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    'dias' . $diascuota = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    //Agregar cuota
    $consultaconsecutivo = "select max(consecutivo)'consecutivo' from registros_cuota where id_registro like '%$ano$mes$dia%'";
    $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
    $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
    if (isset($filaconsecutivo)) {
        $consecutivo = $filaconsecutivo['consecutivo'] + 1;
    } else {
        $consecutivo = 1;
    }
    $idcuota = $ano . $mes . $dia . $consecutivo;

    if (isset($filasverificar)) {
    } else {
        $datetime1 = date_create($filas2['fecha']);
        $datetime2 = date_create($fecha_actual);
        $contador = date_diff($datetime1, $datetime2);
        $differenceFormat = '%a';
        $diasvence =  $contador->format($differenceFormat);

        $consulta = "INSERT INTO `registros_cuota`(`id_registro`, `prestamo`, `cuota`, `fecha`,saldo,atraso,diasvence,valorpagar,consecutivo,liquidado) VALUES "
            . "($idcuota,$id,$recoger,'$fecha','$filas1[debe]','$atraso',$diasvence,'$filas1[valorapagar]',$consecutivo,1) ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    //descontar en prestamo

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
