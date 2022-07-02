

<?php
// include class
require('../librerias/fpdf/fpdf.php');
require_once("../conexion/conexion.php");
date_default_timezone_set('America/Bogota');
$ruta = $_GET['ruta'];
$consultanombreruta = "select * from rutas where id_ruta=$ruta";
$querynombreruta = mysqli_query($link, $consultanombreruta) or die($consultanombreruta);
$filasnombreruta = mysqli_fetch_array($querynombreruta);
$nombreruta = $filasnombreruta['ruta'];
$fecha_actual = date("Y-m-d");
$consultaruta = "select a.*,b.nombre,b.nota from prestamos a inner join clientes b on a.cliente=b.id_cliente  where a.ruta = $ruta and a.abonado < a.valorapagar order by a.posicion_ruta ";
$query = mysqli_query($link, $consultaruta) or die($consultaruta);

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        // $this->Image('logo.png', 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 16);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(40, 10, 'Guia de Rutas', 1, 0, 'C');

        // Salto de línea
        $this->Ln(20);
        //cabecera

    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('../imagenes/logo1.png', 0, 0, 90);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(50, 10, 'Ruta :' . $nombreruta, 0, 1, 'C', 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
$pdf->Cell(40, 10, 'Nota', 1, 0, 'C', 0);
$pdf->Cell(20, 10, 'Fecha P', 1, 0, 'C', 0);
$pdf->Cell(20, 10, utf8_decode('Préstamo'), 1, 0, 'C', 0);
$pdf->Cell(15, 10, 'Saldo', 1, 0, 'C', 0);
$pdf->Cell(20, 10, 'Abono', 1, 0, 'C', 0);
$pdf->Cell(10, 10, 'DA', 1, 0, 'C', 0);
$pdf->Cell(10, 10, 'DV', 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 10);
while ($filas1 = mysqli_fetch_array($query)) {
    //consulta cuota
    $fecha_actual = date("Y-m-d");
    $consultacuota = "select cuota from registros_cuota where prestamo = $filas1[id_prestamo] and fecha='$fecha_actual'";
    $query1 = mysqli_query($link, $consultacuota) or die($consultacuota);
    $filacuota = mysqli_fetch_array($query1);
    if (isset($filacuota)) {
        $cuota = $filacuota['cuota'];
    } else {
        $cuota = "";
    }


    //dias para vencimiento de prestamo activo
    $fecha_actual = date_create($fecha_actual);
    $diasprestamoactivo = $filas1['dias_prestamo'];
    $fechaprestamoactivo = $filas1['fecha'];
    $fechaprestamoactivo = date_create($fechaprestamoactivo);
    date_add($fechaprestamoactivo, date_interval_create_from_date_string("$diasprestamoactivo days"));
    $fechafinprestamo = date_format($fechaprestamoactivo, "d-m-Y");
    $diff = $fecha_actual->diff($fechaprestamoactivo);
    $vencimiento = $diff->days;
    $fechafinprestamo = date_create($fechafinprestamo);
    if ($fechafinprestamo > $fecha_actual) {
        $vencimiento = $vencimiento * -1;
    }
    $vencimiento . '-';

    if ($vencimiento > 0) {
        $class = 'input-disabled-vencido';
    } else {
        $class = 'input-disabled-normal';
    }
    $pdf->Cell(45, 10, $filas1['nombre'], 1, 0, 'C', 0);
    $pdf->Cell(40, 10, $filas1['nota'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $filas1['fecha'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $filas1['valor_prestamo'], 1, 0, 'C', 0);
    $pdf->Cell(15, 10, $filas1['valorapagar'] - $filas1['abonado'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $cuota, 1, 0, 'C', 0);
    $pdf->Cell(10, 10, $filas1['dias_atraso'], 1, 0, 'C', 0);
    $pdf->Cell(10, 10, $vencimiento, 1, 1, 'C', 0);
}
$pdf->Output();
