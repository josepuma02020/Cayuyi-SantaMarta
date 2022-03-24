<?php

session_start();
if ($_SESSION['usuario'] and $_SESSION['Rol'] == 1) {
    include('../conexion/conexion.php');
    $estado = $_GET['estado'];
    if ($estado == 0) {
        $nestado = 1;
    } else {
        $nestado = 0;
    }
    $consulta = "update usuarios set activo=$nestado";
    $query = mysqli_query($link, $consulta) or die($consulta);
    header('Location: ' . "../diario.php");
} else {
    header('Location: ' . "index.php?m=3");
}
