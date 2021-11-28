    <?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
     $id = $_POST['idu'];
    $posicion = $_POST['posicion'];
    $ruta = $_POST['ruta'];
    $consultaposicion = "select posicion_ruta,ruta from prestamos where id_prestamo = $id";
    $query = mysqli_query($link, $consultaposicion) or die($consultaposicion);
    $filas1 = mysqli_fetch_array($query);
     $posicionactual = $filas1['posicion_ruta'];
    $rutaactual = $filas1['ruta'];
        if ($posicionactual > $posicion) {
          echo $consultaposicionmayor = "UPDATE `prestamos` SET `posicion_ruta`=posicion_ruta +1 WHERE ruta = $rutaactual and posicion_ruta between $posicion and $posicionactual";
        } else {
           // $consultaposicionmayor = "UPDATE `prestamos` SET `posicion_ruta`=posicion_ruta -1 WHERE ruta = $rutaactual and posicion_ruta <= $posicionactual";
        }
         $consultauno = "UPDATE `prestamos` SET `posicion_ruta`=posicion_ruta +1 WHERE ruta = $rutaactual and posicion_ruta = $posicion";
        //$query = mysqli_query($link, $consultauno) or die($consultauno);
        echo $query = mysqli_query($link, $consultaposicionmayor) or die($consultaposicionmayor);
        $consultaposicionmenor = "UPDATE `prestamos` SET `posicion_ruta`=$posicion WHERE id_prestamo = $id";
       echo $query = mysqli_query($link, $consultaposicionmenor) or die($consultaposicionmenor);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
