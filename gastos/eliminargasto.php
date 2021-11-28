<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['id'];
    
    $consulta = "DELETE FROM `gastos` WHERE id_gasto = $id";
   echo $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>