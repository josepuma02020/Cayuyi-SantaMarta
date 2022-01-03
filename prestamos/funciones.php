<?php
class prestamos
{
    public function baseruta($id)
    {
        include('../conexion/conexion.php');
        $consultadatos = "select base from rutas where id_ruta = $id";
        $query = mysqli_query($link, $consultadatos) or die($consultadatos);
        $ver = mysqli_fetch_row($query);
        $datos = array(
            'base' => $ver[0],

        );
        return $datos;
    }
    public function obtenerdatosprestamo($id)
    {

        include('../conexion/conexion.php');
        $consultadatos = "select b.cedula,b.nombre,b.apellido,a.ruta,c.ruta,COUNT(a.id_prestamo) 'cuenta-ruta',d.nombre'nomencarg',d.apellido'apellencarg',a.posicion_ruta,a.fecha,a.valor_prestamo,a.valorapagar,(a.valorapagar-a.valor_prestamo) 'intereses',a.dias_prestamo,a.formapago,a.dias_atraso,a.abonado "
            . "from prestamos a "
            . "inner join clientes b on a.cliente=b.id_cliente "
            . "inner join rutas c on c.id_ruta=a.ruta "
            . "inner join usuarios d on c.encargado = d.id_usuario "
            . "where a.id_prestamo = '$id'"
            . "GROUP by a.ruta ";

        $query = mysqli_query($link, $consultadatos) or die($consultadatos);
        $ver = mysqli_fetch_row($query);
        $forma = "Diario";
        switch ($ver[14]) {
            case 1:
                $forma = "Diario";
                break;
            case 7:
                $forma = "Semanal";
                break;
            case 15:
                $forma = "Quincenal";
                break;
            case 30:
                $forma = "Mensual";
                break;
        }
        $datos = array(
            'id' => $id,
            'cedula' => $ver[0],
            'nombrecliente' => $ver[1] . ' ' . $ver[2],
            'idruta' => $ver[3],
            'nombreruta' => $ver[4] . '-' . $ver[6] . ' ' . $ver[7],
            'posicion' => $ver[8],
            'fecha' => $ver[9],
            'valor' => $ver[10],
            'pagar' => $ver[11],
            'intereses' => $ver[12],
            'dias' => $ver[13],
            'cuota' => $ver[11] / $ver[13],
            'porcentaje' => ((($ver[11] - $ver[10]) * 100) / $ver[11]),
            'formapago' => $forma,
            'valorforma' => $ver[14],
            'atraso' => $ver[15],
            'abonado' => $ver[16],
        );
        return $datos;
    }
    public function obtenerdatoscliente($cliente)
    {
        include('../conexion/conexion.php');
        $consultadatos = "SELECT a.nombre,a.apellido,count(b.id_prestamo) 'prestamos',a.telefono,a.direccion from clientes a left join prestamos b on a.id_cliente = b.cliente where a.cedula = '$cliente'";
        $query = mysqli_query($link, $consultadatos) or die($consultadatos);
        $ver = mysqli_fetch_row($query);
        $consultaultimo = "SELECT a.valor_prestamo,a.fecha,a.dias_atraso,a.fechacierre,(valorapagar-abonado) 'debe',c.ruta ,a.dias_prestamo  FROM prestamos a inner join clientes b on b.id_cliente=a.cliente inner join rutas c on c.id_ruta=a.ruta where b.cedula = '$cliente' order by fecha desc limit 1";
        $query1 = mysqli_query($link, $consultaultimo) or die($consultaultimo);
        $ver1 = mysqli_fetch_row($query1);
        if (isset($ver1)) {
            $fecha = $ver1[1];
            $dias = $ver1[2];
            $debe = $ver1[4];
            $ruta = $ver1[5];
            $diasprestamo = $ver1[6];
            $valorultimo = $ver1[0];
            $mod_date = strtotime($fecha . "+" . $dias . " days");
            $fechavence = date("Y-m-d", $mod_date);
            if ($ver1[4] > 0) {
                $activo = 'Si';
            } else {
                $activo = 'No';
            }
        } else {
            $fecha = 0;
            $dias = 0;
            $debe = 0;
            $fechavence = 0;
            $ruta = 0;
            $diasprestamo = 0;
            $valorultimo = 0;
            $activo = 'No';
        }
        $datos = array(
            'nombre' => $ver[0],
            'apellido' => $ver[1],
            'prestamos' => $activo,
            'valorultimo' => $valorultimo,
            'fecha' => $fecha,
            'dias' => $dias,
            'debe' => $debe,
            'cierre' => $fechavence,
            'ruta' => $ruta,
            'diasprestamo' => $diasprestamo,
            'telefono' =>  $ver[3],
            'direccion' =>  $ver[4],
        );
        return $datos;
    }
}
