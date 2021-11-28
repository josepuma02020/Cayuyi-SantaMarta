<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['id'];
    //buscar  cuota
    $consultavalor = "select * from registros_cuota where id_registro = $id";
    $query = mysqli_query($link, $consultavalor) or die($consultavalor);
    $filas1 = mysqli_fetch_array($query);
    $idprestamo=$filas1['prestamo'];
    $cuota=$filas1['cuota'];
    $consulta = "select valorapagar/dias_prestamo 'valorcuota',valorapagar from prestamos where id_prestamo=$idprestamo";
    $query = mysqli_query($link, $consulta) or die($consulta);
    $filas2 = mysqli_fetch_array($query);
    $resta = number_format(($cuota / $filas2['valorcuota']) - 1); 
    $valorpagar=$filas2['valorapagar'];
    if ($cuota == 0) {
        $consulta = "update prestamos set dias_atraso = dias_atraso - 1 where id_prestamo=$idprestamo";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }else{
         $consulta = "update prestamos set dias_atraso = dias_atraso + $resta where id_prestamo=$idprestamo ";
        $query = mysqli_query($link, $consulta) or die($consulta);
        $consulta = "update prestamos set abonado = abonado - $cuota where id_prestamo=$idprestamo ";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if($valorpagar > ($valorpagar - $cuota)){
        $consulta = "update prestamos set fechacierre = 'NULL' where id_prestamo=$idprestamo";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
    $consulta = "DELETE FROM `registros_cuota` WHERE id_registro=$id";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
