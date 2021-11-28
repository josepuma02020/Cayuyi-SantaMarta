<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $cedula = $_POST['cedula'];
    $ruta = $_POST['ruta'];
    $fecha = $_POST['fecha'];
    $valor = $_POST['valor'];
    $totalpagar = $_POST['totalpagar'];
    $dias = $_POST['dias'];
    $formapago = $_POST['formapago'];
    $papeleria = $_POST['papeleria'];
    //restar base
    //$consultabase = " UPDATE `rutas` SET `base`=base - $valor  WHERE id_ruta = $ruta";
    //$query = mysqli_query($link, $consultabase) or die($consultabase);
    //posiciones
    $consultaposiciones = "select max(a.posicion_ruta) 'posicion' from prestamos a where a.ruta=$ruta";
    $query = mysqli_query($link, $consultaposiciones) or die($consultaposiciones);
    $filas2 = mysqli_fetch_array($query);
    $posicion = $filas2['posicion'] + 1;
    //consulta id cliente
    $consultacliente = "select id_cliente from clientes where cedula = $cedula";
    $query = mysqli_query($link, $consultacliente) or die($consultacliente);
    $filas1 = mysqli_fetch_array($query);
    //consultaingresoprestamo
    $consulta = "INSERT INTO `prestamos`(`id_prestamo`, `cliente`, `ruta`, `valor_prestamo`, `valorapagar`, `abonado`, `dias_atraso`, `fecha`, `dias_prestamo`, `posicion_ruta`, `formapago`, `papeleria`) VALUES "
            . "('','$filas1[id_cliente]','$ruta',$valor,$totalpagar,0,0,'$fecha','$dias',$posicion,$formapago,'$papeleria')";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
