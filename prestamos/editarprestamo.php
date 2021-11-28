<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['idu'];
    $rutacambio = $_POST['ruta'];
    $totalpagar = $_POST['totalpagar'];
    $dias = $_POST['dias'];
    $formapago = $_POST['nformapago'];
    $prestamo = $_POST['valoru'];
    //buscar ruta
    $consulta = "select * from prestamos where id_prestamo = $id";
    $query = mysqli_query($link, $consulta) or die($consulta);
    $filas2 = mysqli_fetch_array($query);
    //descuento base
    $ruta = $filas2['ruta'];
    $valorviejo = $filas2['valor_prestamo'];
    $descuentobase = $valorviejo - $prestamo;
    $consulta = "UPDATE `rutas` SET  `base`=base + $descuentobase WHERE id_ruta = $ruta";
    $query = mysqli_query($link, $consulta) or die($consulta);
    if ($formapago != 0) {
        $consulta = "UPDATE `prestamos` SET  `formapago`='$formapago' WHERE id_prestamo = $id";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
    $consulta = "UPDATE `prestamos` SET  `valor_prestamo`='$prestamo' WHERE id_prestamo = $id";
    $query = mysqli_query($link, $consulta) or die($consulta);
    if ($ruta != 0) {
         $consulta = "UPDATE `prestamos` SET  `ruta`='$rutacambio' WHERE id_prestamo = $id";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    $consulta = "UPDATE `prestamos` SET  `valorapagar`='$totalpagar',`dias_prestamo`='$dias' WHERE id_prestamo = $id";
    $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>

