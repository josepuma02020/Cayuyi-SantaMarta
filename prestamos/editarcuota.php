<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['idu'];
    $cuota = $_POST['ncuota'];
    $consultasaldo = "select saldo,cuota,prestamo from registros_cuota where id_registro = $id";
    $query = mysqli_query($link, $consultasaldo) or die($consultasaldo);
    $filassaldo = mysqli_fetch_array($query);
    $saldoactual = $filassaldo['saldo'];
    $cuotaactual = $filassaldo['cuota'];
    if ($cuotaactual > $cuota) {
        $nsaldo = $cuotaactual - $cuota;
        $consulta = "UPDATE `registros_cuota` SET `cuota`=$cuota ,`saldo`= $saldoactual + $nsaldo WHERE id_registro = $id";
        $query = mysqli_query($link, $consulta) or die($consulta);
        $consulta = "UPDATE `prestamos` SET `abonado`= abonado - $nsaldo  WHERE id_prestamo = $filassaldo[prestamo]";
        $query = mysqli_query($link, $consulta) or die($consulta);
    } else {
        $nsaldo = $cuota - $cuotaactual;
        $consulta = "UPDATE `registros_cuota` SET `cuota`=$cuota ,`saldo`= $saldoactual - $nsaldo WHERE id_registro = $id";
        $query = mysqli_query($link, $consulta) or die($consulta);
        $consulta = "UPDATE `prestamos` SET `abonado`= abonado + $nsaldo  WHERE id_prestamo = $filassaldo[prestamo]";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
