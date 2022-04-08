<?php
session_start();
require './fpdf/fpdf.php';
include '../library/configServer.php';
include '../library/consulSQL.php';

date_default_timezone_set('America/Bogota');

$id = $_GET['id'];
$sVenta = ejecutarSQL::consultar("SELECT * FROM reporte WHERE id='$id'");
$dVenta = mysqli_fetch_array($sVenta, MYSQLI_ASSOC);

// // Pruebas
// $fecha = "30-03-2022";
// $sDet = ejecutarSQL::consultar("SELECT c.Nombre, c.Apellido, c.NIT, d.CantidadProductos, d.PrecioProd, v.Fecha
//                                     FROM detalle AS d 
//                                         JOIN venta AS v
//                                     ON d.NumPedido = v.NumPedido 
//                                         JOIN cliente AS c 
//                                     ON v.NIT = c.NIT
//                                     WHERE Fecha='" . substr($fecha, 0, 10) . "'");
// $fila1 = mysqli_fetch_array($sDet, MYSQLI_ASSOC);
// var_dump($fila1);
// exit;


class PDF extends FPDF
{

    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image("../assets/img/Favicom.png", 30, 8, 13);
        // Arial bold 25
        $this->SetFont("Arial", "B", 25);
        //celda vacía
        $this->Cell(25);
        // Título
        $this->Cell(140, 8, utf8_decode('Max-Vitrinas'), 0, 1, 'C');
        // salto linea
        $this->Ln(5);
    }

    // Pie de página
    function Footer()
    {
        // Helvetica bold 8
        $this->SetFont('helvetica', 'B', 8);
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Número de página
        $this->Cell(85, 5, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'L');
        // fecha
        $this->Cell(95, 5, date('d/m/Y | g:i:a'), 0, 1, 'R');
        // linea
        $this->Line(20, 287, 200, 287);
        // Marca
        $this->Cell(0, 5, utf8_decode("Max-Vitrinas® / Marca registrada"), 0, 0, "C");
    }
}
ob_end_clean();
$pdf = new PDF('P', 'mm');
$pdf->SetAuthor("Max-vitrinas", true);
$pdf->SetTitle('Reporte_' . $dVenta['tipo'] . 's #' . $id, true);
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetTopMargin(500);
$pdf->SetLeftMargin(20);
$pdf->SetRightMargin(10);
$pdf->SetDrawColor(255, 255, 255);
$pdf->SetFillColor(10, 150, 255);
$pdf->SetFont("Arial", "", 14);
$pdf->Cell(170, 8, utf8_decode('Reporte ' . $dVenta['tipo'] . 's #' . $id), 0, 1, 'C');
$pdf->Ln(20);
$pdf->SetFont("Arial", "b", 12);
$pdf->Cell(40, 5, utf8_decode('Fecha del Reporte: '), 0);
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(37, 5, utf8_decode($dVenta['fecha']), 0);
$pdf->Ln(12);

// Tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, 10, utf8_decode('N°'), 1, 0, 'C', 1);
$pdf->Cell(70, 10, utf8_decode('Nombre Cliente'), 1, 0, 'C', 1);
$pdf->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', 1);
$pdf->Cell(36, 10, utf8_decode('Cantidad productos'), 1, 0, 'C', 1);
$pdf->Cell(30, 10, utf8_decode('Total'), 1, 1, 'C', 1);
$pdf->SetFont("Arial", "", 12);
$suma = 0;
// Llamado de la base de datos
$sDet = ejecutarSQL::consultar("SELECT c.Nombre, c.Apellido, c.NIT, d.CantidadProductos, d.PrecioProd, v.Fecha
                                    FROM detalle AS d 
                                        JOIN venta AS v
                                    ON d.NumPedido = v.NumPedido 
                                        JOIN cliente AS c 
                                    ON v.NIT = c.NIT
                                    WHERE Fecha='" . substr($dVenta['fecha'], 0, 10) . "'");
$cr = 0;
while ($fila1 = mysqli_fetch_array($sDet, MYSQLI_ASSOC)) {
    // $consulta = ejecutarSQL::consultar("SELECT * FROM producto WHERE CodigoProd='" . $fila1['CodigoProd'] . "'");
    // $fila = mysqli_fetch_array($consulta, MYSQLI_ASSOC);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetDrawColor(65, 61, 61);
    $pdf->Cell(12, 10, utf8_decode($cr+1), 'B', 0, 'C');
    $pdf->Cell(70, 10, utf8_decode($fila1['Nombre']." ". $fila1['Apellido']), 'B', 0, 'C');
    $pdf->Cell(30, 10, utf8_decode('$' . $fila1['NIT']), 'B', 0, 'C');
    $pdf->Cell(36, 10, utf8_decode($fila1['CantidadProductos']), 'B', 0, 'C');
    $pdf->Cell(30, 10, utf8_decode('$' . $fila1['PrecioProd'] * $fila1['CantidadProductos']), 'B', 0, 'C');
    $pdf->Ln(10);
    $suma += $fila1['PrecioProd'] * $fila1['CantidadProductos'];
    // mysqli_free_result($consulta);
    $cr++;
}

$pdf->SetFont("Arial", "b", 12);
$pdf->Cell(12, 10, utf8_decode(''), 0, 0, 'C');
$pdf->Cell(76, 10, utf8_decode(''), 0, 0, 'C');
$pdf->Cell(30, 10, utf8_decode(''), 0, 0, 'C');
$pdf->Cell(30, 10, utf8_decode(''), 0, 0, 'C');
$pdf->Cell(30, 10, utf8_decode('$' . number_format($suma, 2)), 'B', 0, 'C');
$pdf->Ln(10);

$pdf->Output('I', 'ReporteCliente-N' . $id . '.pdf');
mysqli_free_result($sVenta);
mysqli_free_result($sDet);
