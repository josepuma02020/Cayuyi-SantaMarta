<?php

session_start();
include('../conexion/conexion.php');
$id = $_POST['id'];
$consultacliente = "select * from clientes where id_cliente = $id";
$querycliente = mysqli_query($link, $consultacliente) or die($consultacliente);
$arreglocliente = mysqli_fetch_array($querycliente);
//prestamos
$consultaprestamos = "select a.*,b.ruta 'nruta' from prestamos a inner join rutas b on a.ruta=b.id_ruta where cliente = $id and valorapagar > abonado";
$query = mysqli_query($link, $consultaprestamos) or die($consultaprestamos);
$arreglo1 = mysqli_fetch_array($query);
if (isset($arreglo1)) {
    $debe = $arreglo1['valorapagar'] - $arreglo1['abonado'];
    $prestamo = $arreglo1['valor_prestamo'];
    $fecha = $arreglo1['fecha'];
    $diasprestamo = $arreglo1['dias_prestamo'];
    $atraso = $arreglo1['dias_atraso'];
    $nruta = $arreglo1['nruta'];
    $fechacierre = $arreglo1['fechacierre'];
} else {
    $debe = 0;
    $prestamo = 0;
    $fecha = 0;
    $diasprestamo = 0;
    $atraso = 0;
    $nruta = 0;
    $fechacierre = 0;
}

if ($debe > 0) {
    $activo = 'Si';
} else {
    $activo = 'No';
}
$datos = array(
    "nombre" => $arreglocliente['nombre'],
    "cedula" => $arreglocliente['cedula'],
    "telefono" => $arreglocliente['telefono'],
    "direccion" => $arreglocliente['direccion'],
    "activo" => $activo,
    "ultprestamo" => $prestamo,
    "fecha" => $fecha,
    "dias" => $diasprestamo,
    "atraso" => $atraso,
    "debe" => $debe,
    "ruta" => $nruta,
    "cierre" => $fechacierre,
    "nota" => $arreglocliente['nota']
);
echo json_encode($datos);
