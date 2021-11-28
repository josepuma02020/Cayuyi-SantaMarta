<?php
session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $clave = $_POST['clave'];
    $usuario = $_POST['usuario'];
    $rol = $_POST['rol'];
    $clave=password_hash($clave, PASSWORD_DEFAULT);
    //consultaingresousuario
    $consulta = "INSERT INTO `usuarios`(`id_usuario`, `nombre`, `apellido`, `cedula`, `direccion`, `celular`, `ult_conexion`, `usuario`, `clave`, `Rol`) VALUES "
            . "('','$nombre','$apellido','$cedula','$direccion','$telefono','0000-00-00','$usuario','$clave','$rol')";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
