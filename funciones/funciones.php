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
