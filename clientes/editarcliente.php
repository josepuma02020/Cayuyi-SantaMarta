<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
  echo  $id = $_POST['idu'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $consulta="UPDATE `clientes` SET `nombre`='$nombre',`apellido`='$apellido',`cedula`='$cedula',`telefono`='$telefono',`direccion`='$direccion' WHERE id_cliente = '$id'";
     $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
