<?php

session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $direccion = $_POST['telefono'];
    $telefono = $_POST['telefono'];
    $usuario = $_POST['usuario'];
    echo $clave = $_POST['clave'];
    $rol = $_POST['rol'];
    $claveh = password_hash($clave, PASSWORD_DEFAULT);
    if ($rol == 0 && $clave == "") {
        $consulta = "UPDATE `usuarios` SET `nombre`='$nombre',`apellido`='$apellido',"
                . "`cedula`='$cedula',`direccion`='$direccion',`celular`='$telefono',`"
                . "usuario`='$usuario' WHERE id_usuario = $id ";
    } elseif ($rol == 0) {
       echo $consulta = "UPDATE `usuarios` SET `nombre`='$nombre',`apellido`='$apellido',"
                . "`cedula`='$cedula',`direccion`='$direccion',`celular`='$telefono',`"
                . "usuario`='$usuario',`clave`='$claveh' WHERE id_usuario = $id ";
    }elseif($clave == ""){
         $consulta = "UPDATE `usuarios` SET `nombre`='$nombre',`apellido`='$apellido',"
                . "`cedula`='$cedula',`direccion`='$direccion',`celular`='$telefono',`"
                . "usuario`='$usuario',`Rol`='$rol' WHERE id_usuario = $id ";
    }else{
        $consulta = "UPDATE `usuarios` SET `nombre`='$nombre',`apellido`='$apellido',"
                . "`cedula`='$cedula',`direccion`='$direccion',`celular`='$telefono',`"
                . "usuario`='$usuario',`Rol`='$rol',`clave`='$claveh' WHERE id_usuario = $id ";
    }
     $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
?>
