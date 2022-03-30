<?php
session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['id'];
    $consulta = "DELETE FROM `revisionesrutas` WHERE idhistorial = $id";
    $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
