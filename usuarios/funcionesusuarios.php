<?php
class usuarios
{

    public function obtenerdatosusuario($id)
    {

        include('../conexion/conexion.php');
        $consultadatos = "select * from usuarios where id_usuario = $id";
        $query = mysqli_query($link, $consultadatos) or die($consultadatos);
        $ver = mysqli_fetch_row($query);
        $datos = array(
            'id' => $id,
            'nombre' => $ver[1],
            'apellido' => $ver[2],
            'cedula' => $ver[3],
            'direccion' => $ver[4],
            'telefono' => $ver[5],
            'ultconexion' => $ver[6],
            'usuario' => $ver[7],
            'clave' => $ver[8],
            'Rol' => $ver[9],
        );
        return $datos;
    }
}
