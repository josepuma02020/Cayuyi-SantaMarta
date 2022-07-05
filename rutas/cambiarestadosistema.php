<?php

session_start();
if ($_SESSION['usuario'] and ($_SESSION['Rol'] == 1 || $_SESSION['Rol'] == 2)) {
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
    session_destroy();
    header('Location: ' . "../index.php?m=3");
}
