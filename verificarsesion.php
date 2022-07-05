
<?php
session_start();
include('conexion/conexion.php');
include('funciones/funciones.php');
date_default_timezone_set('America/Bogota');
$usuario = htmlentities($_POST['usuario']);
$clave1 = htmlentities($_POST['clave']);
echo $consulta = "SELECT a.*,b.id_ruta,b.ruta FROM usuarios a left join rutas b on b.encargado = a.id_usuario
WHERE usuario='$usuario' ";
$query = mysqli_query($link, $consulta) or die($consulta);
$arreglo = mysqli_fetch_array($query);
if ($arreglo['activo'] == 1 && ($arreglo['Rol'] == 3 || $arreglo['Rol'] == 4)) {
    header('Location: ' . "index.php?m=4");
} else {
    if ($arreglo['Rol'] == "4") {
        header('Location: ' . "index.php?m=1");
    } else {
        $clave2 = $arreglo['clave'];
        $fecha = date("Y" . "-" . "m" . "-" . "d");
        $rol = $arreglo['Rol'];
        switch ($rol) {
            case '1':
                $menu = "diseno/navegadoradmin.php";
                break;
            case 2:
                $menu = "diseno/navegadorsupervisor.php";
                break;
            case 3:
                $menu = "diseno/navegadorcobrador.php";
                break;
        }
        //ruta
        if (password_verify($clave1, $clave2)) {
            echo 1;
            $_SESSION['id_usuario'] = $arreglo['id_usuario'];
            $_SESSION['usuario'] = $usuario;
            $_SESSION['Rol'] = $rol;
            $_SESSION['menu'] = $menu;
            $_SESSION['ruta'] = $arreglo['id_ruta'];
            $_SESSION['nruta'] = $arreglo['ruta'];
            $_SESSION['nombre'] = $arreglo['nombre'];
            $_SESSION['apellido'] = $arreglo['apellido'];
            $_SESSION['apellido'] = $arreglo['apellido'];
            $_SESSION['ultimaconexion'] = $arreglo['ult_conexion'];
            $_SESSION['tiempo'] = time();
            $consultaactconex = "update usuarios set ult_conexion = '$fecha' where id_usuario = $_SESSION[id_usuario]  ";
            $query = mysqli_query($link, $consultaactconex) or die($consultaactconex);
            header('Location: ' . "diario.php");
        } else {
            header('Location: ' . "index.php?m=2");
        }
    }
}
