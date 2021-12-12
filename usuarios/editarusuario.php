<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];
    $claveh = password_hash($clave, PASSWORD_DEFAULT);
    if($rol != "0"){
        $consulta = "UPDATE `usuarios` SET `rol`='$rol' WHERE id_usuario = $id ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if($nombre != ""){
        $consulta = "UPDATE `usuarios` SET `nombre`='$nombre' WHERE id_usuario = $id ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if($apellido != ""){
        $consulta = "UPDATE `usuarios` SET `apellido`='$apellido' WHERE id_usuario = $id ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if($cedula != ""){
        $consulta = "UPDATE `usuarios` SET `cedula`='$cedula' WHERE id_usuario = $id ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if($direccion != ""){
        $consulta = "UPDATE `usuarios` SET `direccion`='$direccion' WHERE id_usuario = $id ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if($telefono != ""){
        $consulta = "UPDATE `usuarios` SET `celular`='$telefono' WHERE id_usuario = $id ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if($usuario != ""){
        $consulta = "UPDATE `usuarios` SET `usuario`='$usuario' WHERE id_usuario = $id ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if($clave != ""){
        $consulta = "UPDATE `usuarios` SET `clave`='$claveh' WHERE id_usuario = $id ";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
