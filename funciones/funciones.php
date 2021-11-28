<?php

function nombrecuenta($id) {
    switch ($id) {
        case '1':
            $cuenta = 'CAJA';
            break;
        case '7':
            $cuenta = 'COSTOS DE PRODUCCION/OPERACION';
            break;
        case '4':
            $cuenta = 'INGRESOS';
            break;
        case '6':
            $cuenta = 'COSTOS DE VENTA';
            break;
        case '5':
            $cuenta = 'GASTOS';
            break;
        case '0':
            $cuenta = 'GANANCIAS RETIRADAS';
            break;
    }
    return $cuenta;
}

function proveedor($id) {
    $_SESSION['proveedor_producto'] = $id;
}

function mes() {
    $mesi = date("F");

    switch ($mesi) {
        case 'August':
            $mese = "Agosto";
            break;
        case 'January':
            $mese = 'Ene';
            break;
        case 'February':
            $mese = 'Feb';
            break;
        case 'March':
            $mese = 'Mar';
            break;
        case 'April':
            $mese = 'Abr';
            break;
        case 'May':
            $mese = 'May';
            break;
        case 'June':
            $mese = 'Jun';
            break;
        case 'July':
            $mese = 'Jul';
            break;
        case 'September':
            $mese = 'Sept';
            break;
        case 'October':
            $mese = 'Oct';
            break;
        case 'November':
            $mese = 'Nov';
            break;
        case 'December':
            $mese = 'Dic';
            break;
    }
    return $mese;
}

function dia() {
    $ndia = date("j");
    $diai = date("l");
    return $ndia;
}

class usuarios {

    public function obtenerdatosusuario($id) {

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

class prestamos {
   public function baseruta($id) {
        include('../conexion/conexion.php');
        $consultadatos = "select base from rutas where id_ruta = $id";
        $query = mysqli_query($link, $consultadatos) or die($consultadatos);
        $ver = mysqli_fetch_row($query);
        $datos = array(
            'base' => $ver  [0],

        );
        return $datos;
    }
    public function obtenerdatosprestamo($id) {

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
            case 1 :
                $forma = "Diario";
                break;
            case 7 :
                $forma = "Semanal";
                break;
            case 15 :
                $forma = "Quincenal";
                break;
            case 30 :
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

    public function obtenerdatoscliente($cliente) {

        include('../conexion/conexion.php');
        $consultadatos = "SELECT a.nombre,a.apellido,count(b.id_prestamo) 'prestamos' from clientes a left join prestamos b on a.id_cliente = b.cliente where a.cedula = '$cliente'";
        $query = mysqli_query($link, $consultadatos) or die($consultadatos);
        $ver = mysqli_fetch_row($query);
        $consultaultimo = "SELECT a.valor_prestamo,a.fecha,a.dias_atraso,a.fechacierre,(valorapagar-abonado) 'debe',c.ruta ,a.dias_prestamo  FROM prestamos a inner join clientes b on b.id_cliente=a.cliente inner join rutas c on c.id_ruta=a.ruta where b.cedula = '$cliente' order by fecha desc limit 1";
        $query1 = mysqli_query($link, $consultaultimo) or die($consultaultimo);
        $ver1 = mysqli_fetch_row($query1);
        if (isset($ver1)) {
            $fecha = $ver1[1];
            $dias = $ver1[2];
            $debe = $ver1[4];
            $cierre = $ver1[3];
            $ruta = $ver1[5];
            $diasprestamo = $ver1[6];
            $valorultimo = $ver1[0];
            if ($ver1[5] > 0) {
                $activo = 'Si';
            } else {
                $activo = 'No';
            }
        } else {
            $fecha = 0;
            $dias = 0;
            $debe = 0;
            $cierre = 0;
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
            'cierre' => $cierre,
            'ruta' => $ruta,
            'diasprestamo' => $diasprestamo,
        );
        return $datos;
    }

}

function buscaridrecibo($link) {
    date_default_timezone_set('America/Bogota');
    if (date('j') < 10) {
        $dia = '0' . date('j');
    } else {
        $dia = date('j');
    }
    $fechahoyhora = date("Y") . '-' . date("m") . '-' . $dia;
    $consultaidrecibo = "select contador from pedidos where  fecha like '$fechahoyhora%' order by `id_pedido`desc limit 1";
    $query = mysqli_query($link, $consultaidrecibo) or die($consultaidrecibo);
    $filasc = mysqli_fetch_array($query);
    date_default_timezone_set('America/Bogota');
    if (date('j') < 10) {
        $dia = '0' . date('j');
    } else {
        $dia = date('j');
    }
    $fechahoy = date("Y") . date("m") . $dia;
    if (isset($filasc['contador'])) {
        $idnuevo = $filasc['contador'];
    } else {
        $idnuevo = '1';
    }

    return $fechahoy . $idnuevo;
}

function nombremes($mes) {
    switch ($mes) {
        case 1:
            $mese = "Enero";
            break;
        case 2:
            $mese = 'Febrero';
            break;
        case 3:
            $mese = 'Marzo';
            break;
        case 4:
            $mese = 'Abril';
            break;
        case 5:
            $mese = 'Mayo';
            break;
        case 6:
            $mese = 'Junio';
            break;
        case 7:
            $mese = 'Julio';
            break;
        case 8:
            $mese = 'Agosto';
            break;
        case 9:
            $mese = 'Septiembre';
            break;
        case 10:
            $mese = 'Octubre';
            break;
        case 11:
            $mese = 'Noviembre';
            break;
        case 12:
            $mese = 'Diciembre';
            break;
    }
    return $mese;
}

function horaformato12($hora) {

    if ($hora <= 12) {
        $hora = $hora;
    } else {
        $hora = ($hora - 12);
    }
    return $hora;
}

?>
