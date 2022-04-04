<?php
session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("j");
    $id = $_POST['id'];
    $rutacambio = $_POST['ruta'];
    $valorref = $_POST['valor'];
    $diasref = $_POST['dias'];
    $comentario = $_POST['comentario'];
    if ($valorref > 0) {
        $consulta = "UPDATE `prestamos` SET `valorapagar`=$valorref,`dias_prestamo`=$diasref,`fecrefinanciacion`='$fechahoyval',`comentario`='$comentario' WHERE id_prestamo=$id";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if ($rutacambio != 0) {
        $consulta = "UPDATE `prestamos` SET  `ruta`='$rutacambio' WHERE id_prestamo = $id";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
}
