<?php
session_start();
include 'conexion.php';

// Llamamos a la librería FPDF que acabas de descargar
require('fpdf/fpdf.php'); 

// Protección básica
if (!isset($_SESSION['usuario'])) {
    die("Acceso denegado. Por favor, inicia sesión.");
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No se especificó ninguna boleta.");
}

$id_pago = mysqli_real_escape_string($conexion, $_GET['id']);
$sql = "SELECT id, fecha, nombre_mascota, servicio, monto, estado FROM pagos WHERE id = '$id_pago'";
$resultado = mysqli_query($conexion, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $pago = mysqli_fetch_assoc($resultado);
    
    $fecha_formateada = date("d/m/Y", strtotime($pago['fecha']));
    $monto_formateado = number_format($pago['monto'], 2);
    $numero_boleta = "BOL-" . str_pad($pago['id'], 6, "0", STR_PAD_LEFT);
    $numero_cita = "CIT-" . str_pad($pago['id'] + 100, 5, "0", STR_PAD_LEFT);
    $cliente = $_SESSION['nombre_usuario'];
} else {
    die("Error: El registro de pago no existe.");
}

// =========================================================
// CREACIÓN DEL PDF CON FPDF
// =========================================================
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título de la clínica
$pdf->SetTextColor(0, 51, 102); // Azul oscuro
// Usamos utf8_decode para que las tildes y las ñ salgan perfectas
$pdf->Cell(190, 10, utf8_decode('MR. FIRULAYS'), 0, 1, 'C'); 
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 8, utf8_decode('Clínica Veterinaria'), 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, utf8_decode('COMPROBANTE DE PAGO ELECTRÓNICO'), 0, 1, 'C');
$pdf->Ln(5); // Salto de línea

// Línea separadora
$pdf->SetDrawColor(0, 51, 102);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(8);

// Datos principales
$pdf->SetTextColor(51, 51, 51); // Gris oscuro
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 7, utf8_decode('N° Comprobante:'), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(150, 7, $numero_boleta, 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 7, utf8_decode('N° de Cita:'), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(150, 7, $numero_cita, 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 7, utf8_decode('Fecha Emisión:'), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(150, 7, $fecha_formateada, 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 7, utf8_decode('Cliente:'), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(150, 7, utf8_decode($cliente), 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 7, utf8_decode('Mascota:'), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(150, 7, utf8_decode($pago['nombre_mascota']), 0, 1);
$pdf->Ln(10);

// Encabezado de la tabla de servicios
$pdf->SetFillColor(240, 240, 240); // Fondo gris claro
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(140, 10, utf8_decode('Descripción del Servicio'), 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Monto', 1, 1, 'C', true);

// Contenido de la tabla
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(140, 10, utf8_decode($pago['servicio']), 1, 0, 'L');
$pdf->Cell(50, 10, 'S/ ' . $monto_formateado, 1, 1, 'R');
$pdf->Ln(5);

// Total a pagar
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 10, '', 0, 0); // Espacio invisible para empujar el total a la derecha
$pdf->Cell(50, 10, 'TOTAL: S/ ' . $monto_formateado, 0, 1, 'R');
$pdf->Ln(15);

// Mensaje de pie de página
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 6, utf8_decode('Estado del Comprobante: ' . strtoupper($pago['estado'])), 0, 1, 'C');
$pdf->SetFont('Arial', 'I', 9);
$pdf->SetTextColor(119, 119, 119);
$pdf->Cell(190, 6, utf8_decode('Gracias por confiar la salud de tu mascota a MR. Firulays'), 0, 1, 'C');

// =========================================================
// SALIDA DEL ARCHIVO: 'D' fuerza la descarga directa
// =========================================================
$pdf->Output('D', $numero_boleta . '.pdf');
?>