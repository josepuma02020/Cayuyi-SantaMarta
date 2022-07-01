<?php
session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("j");
    $fecha_actual = date("Y-m-j");
    $id = $_POST['id'];
    $rutacambio = $_POST['ruta'];
    $valorref = $_POST['valor'];
    $diasref = $_POST['dias'];
    $comentario = $_POST['comentario'];
    //buscar prestamo
    $consulta = "select * from prestamos where id_prestamo = $id";
    $query = mysqli_query($link, $consulta) or die($consulta);
    $filas2 = mysqli_fetch_array($query);

    if ($valorref > 0) {
        $consulta = "UPDATE `prestamos` SET `valorapagar`=$valorref,`dias_prestamo`=$diasref,`fecrefinanciacion`='$fechahoyval',`comentario`='$comentario' WHERE id_prestamo=$id";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if ($rutacambio != 0) {
        $consulta = "UPDATE `prestamos` SET  `ruta`='$rutacambio' WHERE id_prestamo = $id";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    //ingresar a refinanciaciones
    $consultafinanciacion = "INSERT INTO `refinanciaciones`(`idrefinanciacion`, `fecha`, `valoranterior`, `valornuevo`, `idprestamo`, `plazoanterior`, `plazonuevo`) VALUES 
    ('','$fecha_actual',$filas2[valorapagar],$valorref,$id,$filas2[dias_prestamo],$diasref)";
    echo $queryfinanciacion = mysqli_query($link, $consultafinanciacion) or die($consultafinanciacion);
}
