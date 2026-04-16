<?php
require('fpdf/fpdf.php'); // Cargar la librería FPDF
include_once 'db.php';
include_once 'Visita.php';

$database = new Database();
$db = $database->getConnection();
$visita = new Visita($db);

// Aplicar búsqueda si viene de la URL
$busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : "";
$stmt = $visita->obtenerTodas($busqueda);

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10,utf8_decode('Reporte de Visitantes'),0,1,'C');
        $this->SetFont('Arial','',10);
        $this->Cell(0,10,'Fecha de reporte: ' . date('d/m/Y H:i A'),0,1,'C');
        $this->Ln(5);
        
        // Cabecera de la tabla
        $this->SetFillColor(52, 58, 64); // Fondo gris oscuro para tabla de cabecera
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','B',10);
        $this->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Visitante', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Persona Visitada', 1, 0, 'C', true);
        $this->Cell(25, 10, 'Fecha', 1, 0, 'C', true);
        $this->Cell(15, 10, 'Entra', 1, 0, 'C', true);
        $this->Cell(15, 10, 'Sale', 1, 0, 'C', true);
        $this->Cell(20, 10, 'Estado', 1, 1, 'C', true);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Creación del objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);

// Cargar y mostrar datos
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $estado = is_null($row['hora_salida']) ? 'Dentro' : 'Fuera';
    $hora_salida_formateada = is_null($row['hora_salida']) ? '-' : date('H:i', strtotime($row['hora_salida']));
    
    // Convertir utf8_decode por algunos acentos
    $pdf->Cell(15, 10, $row['id'], 1, 0, 'C');
    
    // Para no exceder el espacio de 50, se acorta si es necesario
    $nombre = substr(utf8_decode($row['nombre_completo']), 0, 25);
    $pdf->Cell(50, 10, $nombre, 1, 0, 'L');
    
    $visitado = substr(utf8_decode($row['persona_visitada']), 0, 25);
    $pdf->Cell(50, 10, $visitado, 1, 0, 'L');
    
    $pdf->Cell(25, 10, $row['fecha'], 1, 0, 'C');
    $pdf->Cell(15, 10, date('H:i', strtotime($row['hora_entrada'])), 1, 0, 'C');
    $pdf->Cell(15, 10, $hora_salida_formateada, 1, 0, 'C');
    
    // Color según estado
    if($estado == 'Dentro'){
        $pdf->SetTextColor(0, 128, 0); // Verde
    } else {
        $pdf->SetTextColor(255, 0, 0); // Rojo
    }
    $pdf->Cell(20, 10, $estado, 1, 1, 'C');
    $pdf->SetTextColor(0,0,0); // Reset color
}

// Genera e imprime el documento
$pdf->Output('I', 'Reporte_Visitas.pdf');
?>
