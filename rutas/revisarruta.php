<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $hora = date('h:i a');
    $fecha_actual = date("Y") . '-' . date("m") . '-' . date("j");
    $fecharevision = $fecha_actual . ' ' . $hora;
    $ide = $_POST['ide'];
    $pleno = $_POST['pleno'];
    $base = $_POST['base'];
    $cobro = $_POST['cobro'];
    $prestamo = $_POST['prestamo'];
    $gasto = $_POST['gasto'];
    $nuevos = $_POST['nuevos'];
    $entrantes = $_POST['entrantes'];
    $salientes = $_POST['salientes'];
    $clientes = $_POST['clientes'];
    $papeleria = $_POST['papeleria'];
    $efectivo = $_POST['efectivo'];
    $fecha = $_POST['fecha'];
    $valornuevos = $_POST['valornuevos'];
    //restar prestamos 
    //encargado
    $consultaruta = "select a.encargado from rutas a where id_ruta=$ide";
    $query = mysqli_query($link, $consultaruta) or die($consultaruta);
    $filas1 = mysqli_fetch_array($query);

    //InsertarRegistro
    $consulta = "INSERT INTO `revisionesrutas`(`idhistorial`, `base`, `cobro`, `prestamo`, `gastos`, `pleno`, `nuevos`, `entrantes`, `salientes`, `clientes`, `ruta`, `encargado`, `fecha`,papeleria,efectivo,idliquidador,hora,valorprestamosnuevos) VALUES "
        . "('','$base','$cobro','$prestamo','$gasto','$pleno','$nuevos','$entrantes','$salientes','$clientes','$ide',$filas1[encargado],'$fecha',$papeleria,$efectivo,$_SESSION[id_usuario],'$fecharevision',$valornuevos)";
    if ($query = mysqli_query($link, $consulta) or die($consulta) == 1) {
        echo 1;
        //descontar base
        $consulta = "UPDATE `rutas` SET `base`=$efectivo WHERE id_ruta=$ide";
        $query = mysqli_query($link, $consulta) or die($consulta);
        //liquidarcuotas
        $consultacuotas = "select c.id_registro from prestamos a INNER JOIN registros_cuota c on c.prestamo=a.id_prestamo where a.ruta = $ide and c.fecha = '$fecha'";
        $querycuotas = mysqli_query($link, $consultacuotas) or die($consultacuotas);
        while ($filascuotas = mysqli_fetch_array($querycuotas)) {
            $consultaestadocuota = "UPDATE `registros_cuota` SET `liquidado`= 2,,`fecha`='$fecha' WHERE `id_registro` =  $filascuotas[id_registro] ";
            $queryestadocuota = mysqli_query($link, $consultaestadocuota) or die($consultaestadocuota);
        }
    }
} else {
    session_destroy();
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
