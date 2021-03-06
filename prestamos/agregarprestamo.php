<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $fecha_actual = date("Y-m-j");
    $cedula = $_POST['cedula'];
    $ruta = $_POST['ruta'];
    $fecha = $_POST['fecha'];
    $fechaprestamo = strtotime($fecha);
    $ano = date('Y', $fechaprestamo);
    $mes = date('m', $fechaprestamo);
    $dia = date('d', $fechaprestamo);
    $valor = $_POST['valor'];
    $totalpagar = $_POST['totalpagar'];
    $dias = $_POST['dias'];
    $formapago = $_POST['formapago'];
    $papeleria = $_POST['papeleria'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $nombre = $_POST['nombre'];
    $domingo = $_POST['domingo'];
    //consulta clientes
    $consultaclienteexistente = "select * from clientes where cedula = '$cedula'";
    $querycliente = mysqli_query($link, $consultaclienteexistente) or die($consultaclienteexistente);
    $filacliente = mysqli_fetch_array($querycliente);
    if (isset($filacliente)) {
    } else {
        $consulta = "INSERT INTO `clientes`(`id_cliente`, `nombre`, `cedula`, `telefono`, `direccion`) VALUES "
            . "('','$nombre','$cedula','$telefono','$direccion') ";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
    //consulta posicion
    $consultaposiciones = "select max(a.posicion_ruta) 'posicion' from prestamos a where a.ruta=$ruta";
    $query = mysqli_query($link, $consultaposiciones) or die($consultaposiciones);
    $filas2 = mysqli_fetch_array($query);
    $posicion = $filas2['posicion'] + 1;
    //consulta id cliente
    $consultacliente = "select id_cliente from clientes where cedula = '$cedula'";
    $query = mysqli_query($link, $consultacliente) or die($consultacliente);
    $filas1 = mysqli_fetch_array($query);

    //consultaingresoprestamo
    switch ($formapago) {
        case 1:
            $cuota = $totalpagar / $dias;
            break;
        case 7:
            $cuota = $totalpagar / $dias;
            $cuota = $cuota * 7;
            break;
        case 15:
            $cuota = $totalpagar / $dias;
            $cuota = $cuota * 15;
            break;
        case 30:
            $cuota = $totalpagar / $dias;
            $cuota = $cuota * 15;
            break;
    }
    $consulta = "INSERT INTO `prestamos`(`id_prestamo`, `cliente`, `ruta`, `valor_prestamo`, `valorapagar`, `abonado`, `dias_atraso`, `fecha`, `dias_prestamo`, `posicion_ruta`, `formapago`, `papeleria`) VALUES "
        . "('','$filas1[id_cliente]','$ruta',$valor,$totalpagar,$domingo,0,'$fecha','$dias',$posicion,$formapago,'$papeleria')";
    $query = mysqli_query($link, $consulta) or die($consulta);

    //registrarcuota
    $consultaid = "select id_prestamo,valorapagar-abonado 'saldo',valorapagar from prestamos order by id_prestamo desc limit 1";
    $query = mysqli_query($link, $consultaid) or die($consultaid);
    $filaid = mysqli_fetch_array($query);
    $id = $filaid['id_prestamo'];
    $saldo = $filaid['saldo'];
    $consultaatraso = "select dias_atraso,fecha,dias_prestamo from prestamos where id_prestamo=$id ";
    $query1 = mysqli_query($link, $consultaatraso) or die($consultaatraso);
    $filas2 = mysqli_fetch_array($query1);
    echo  $consultaconsecutivo = "select max(consecutivo)'consecutivo' from registros_cuota where id_registro like '%$ano$mes$dia%'";
    $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
    $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
    if (isset($filaconsecutivo)) {
        $consecutivo = $filaconsecutivo['consecutivo'] + 1;
    } else {
        $consecutivo = 1;
    }
    $idcuota = $ano . $mes . $dia . $consecutivo;
    $atraso = $filas2['dias_atraso'];
    $diasprestamo = $filas2['dias_prestamo'];
    $diasprestamo--;
    $fechavence = date("Y-m-d", strtotime($filas2['fecha'] . "+ " . $diasprestamo . "days"));
    $dateDifference = abs(strtotime($fecha_actual) - strtotime($fechavence));
    $years = floor($dateDifference / (365 * 60 * 60 * 24));
    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $diascuota = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

    //dias para vencimiento de prestamo activo
    $fecha_actual = date_create($fecha_actual);
    $diasprestamoactivo = $filas2['dias_prestamo'];
    $fechaprestamoactivo = $filas2['fecha'];
    $fechaprestamoactivo = date_create($fechaprestamoactivo);
    date_add($fechaprestamoactivo, date_interval_create_from_date_string("$diasprestamoactivo days"));
    $fechafinprestamo = date_format($fechaprestamoactivo, "d-m-Y");
    $diff = $fecha_actual->diff($fechaprestamoactivo);
    $vencimiento = $diff->days;
    $fechafinprestamo = date_create($fechafinprestamo);
    if ($fechafinprestamo > $fecha_actual) {
        $vencimiento = $vencimiento * -1;
    }
    echo $vencimiento;
    $consulta = "INSERT INTO `registros_cuota`(`id_registro`, `prestamo`, `cuota`, `fecha`,saldo,atraso,diasvence,valorpagar,consecutivo,liquidado) VALUES "
        . "('$idcuota',$id,$domingo,'$fecha','$filaid[saldo]','$atraso','$vencimiento','$filaid[valorapagar]',$consecutivo,1) ";
    $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
