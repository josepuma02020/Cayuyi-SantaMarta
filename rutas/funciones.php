<?php
include('../conexion/conexion.php');
class Tarjeta
{
    public function ordernarTarjetas($tarjetasordenadas)
    {
        foreach ($tarjetasordenadas as $tarjeta)
            $consulta = "update prestamos set posicion_ruta =  $tarjeta -> orden where id_prestamo = $tarjeta->id";
    }
}
