
<?php
session_start();
include('conexion/conexion.php');
include('funciones/funciones.php');
$usuario = htmlentities($_POST['usuario']);
$clave1 = htmlentities($_POST['clave']);
echo $consulta = "SELECT a.*,b.id_ruta,b.ruta FROM usuarios a left join rutas b on b.encargado = a.id_usuario
WHERE usuario='$usuario' ";
$query = mysqli_query($link, $consulta) or die($consulta);
$arreglo = mysqli_fetch_array($query);
if($arreglo['Rol'] == "Inactivo"){
    header('Location: '."index.php?m=1");
}else{
$clave2 = $arreglo['clave'];
$fecha = date("Y" . "-" . "m" . "-" . "d");
//ruta
if (password_verify($clave1, $clave2)) {
    echo 1;
    $_SESSION['id_usuario'] = $arreglo['id_usuario'];
    $_SESSION['usuario'] = $usuario;
    $_SESSION['Rol'] = $arreglo['Rol'];
    $_SESSION['ruta'] = $arreglo['id_ruta'];
    $_SESSION['nruta'] = $arreglo['ruta'];
    $_SESSION['nombre'] = $arreglo['nombre'];
    $_SESSION['apellido'] = $arreglo['apellido'];
    $_SESSION['apellido'] = $arreglo['apellido'];
    $_SESSION['ultimaconexion'] = $arreglo['ult_conexion'];
    $consultaactconex = "update usuarios set ult_conexion = '$fecha' where id_usuario = $_SESSION[id_usuario]  ";
    $query = mysqli_query($link, $consultaactconex) or die($consultaactconex);
    header('Location: '."diario.php");
}else{

}
}



