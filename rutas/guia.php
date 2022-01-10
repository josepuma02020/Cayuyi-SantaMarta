

<?php
// include class
require('../librerias/fpdf/fpdf.php');
require_once("../conexion/conexion.php");
$ruta = $_GET['ruta'];
$consultanombreruta = "select * from rutas where id_ruta=$ruta";
$querynombreruta = mysqli_query($link, $consultanombreruta) or die($consultanombreruta);
$filasnombreruta = mysqli_fetch_array($querynombreruta);
$nombreruta = $filasnombreruta['ruta'];
$consultaruta = "select a.*,b.nombre,b.apellido from prestamos a inner join clientes b on a.cliente=b.id_cliente  where a.ruta = $ruta and a.abonado < a.valorapagar";
$query = mysqli_query($link, $consultaruta) or die($consultaruta);
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        // $this->Image('logo.png', 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
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
$pdf->Cell(50, 10, 'Ruta :' . $nombreruta, 0    , 1, 'C', 0);
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
    $pdf->Cell(50, 10, $filas1['nombre'] . ' ' . $filas1['apellido'], 1, 0, 'C', 0);
    $pdf->Cell(30, 10, $filas1['fecha'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $filas1['valor_prestamo'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $filas1['valorapagar'] - $filas1['abonado'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, '', 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $filas1['dias_atraso'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, '', 1, 1, 'C', 0);
}
$pdf->Output();
