

<?php
// include class
require('../librerias/fpdf/fpdf.php');
require_once("../conexion/conexion.php");
date_default_timezone_set('America/Bogota');
$fecha = $_GET['fecha'];
$fecha_actual = date("Y-m-d");
$consultacobros = "select a.*,b.*,c.nombre from registros_cuota a inner join prestamos b on a.prestamo=b.id_prestamo inner join clientes c on c.id_cliente=b.cliente where a.fecha ='$fecha' order by a.posicion_ruta";
$query = mysqli_query($link, $consultacobros) or die($consultacobros);

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        // $this->Image('logo.png', 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 20);
        // Movernos a la derecha
        $this->Cell(100);
        // Título
        $this->Cell(60, 10, 'Resumen de Cobros', 0, 0, 'C');
        // Salto de línea
        $this->Ln(30);
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
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(50, 10, 'Fecha :' . $fecha, 0, 1, 'C', 0);
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Nombre', 1, 0, 'C', 0);
$pdf->Cell(30, 10, 'Fecha P', 1, 0, 'C', 0);
$pdf->Cell(20, 10, utf8_decode('Préstamo'), 1, 0, 'C', 0);
$pdf->Cell(20, 10, 'Saldo', 1, 0, 'C', 0);
$pdf->Cell(20, 10, 'Abono', 1, 0, 'C', 0);
$pdf->Cell(20, 10, 'DA', 1, 0, 'C', 0);
$pdf->Cell(20, 10, 'DV', 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 12);
while ($filas1 = mysqli_fetch_array($query)) {
    //consulta cuota
    $fecha_actual = date("Y-m-d");
    $consultacuota = "select cuota from registros_cuota where prestamo = $filas1[prestamo] and fecha='$fecha_actual'";
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
    $pdf->Cell(50, 10, $filas1['nombre'], 1, 0, 'C', 0);
    $pdf->Cell(30, 10, $filas1['fecha'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $filas1['valor_prestamo'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $filas1['valorapagar'] - $filas1['abonado'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $cuota, 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $filas1['dias_atraso'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $vencimiento, 1, 1, 'C', 0);
}
$pdf->Output();
