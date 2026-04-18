<?php
require_once 'config/Database.php';
require_once 'models/Visita.php';

$db = Database::getInstance()->getConnection();
$v_model = new Visita($db);
$visitas = $v_model->obtenerTodas($_GET['buscar'] ?? "");

// --- Generación de HTML Compacto ---
$html = '<h1 style="text-align:center; color:#0056b3;">REPORTE DE VISITAS</h1>';
$html .= '<table border="1" width="100%" cellpadding="10" style="border-collapse:collapse; font-family:Arial;">
    <tr style="background:#333; color:#fff;">
        <th>ID</th><th>Visitante</th><th>Visitado</th><th>Fecha</th><th>Entrada</th><th>Salida</th>
    </tr>';

foreach ($visitas as $v) {
    $html .= "<tr>
        <td>#{$v->id}</td>
        <td><b>" . htmlspecialchars($v->nombre_completo) . "</b></td>
        <td>" . htmlspecialchars($v->persona_visitada) . "</td>
        <td>{$v->fecha}</td>
        <td>" . $v_model->formatHora($v->hora_entrada) . "</td>
        <td>" . $v_model->formatHora($v->hora_salida) . "</td>
    </tr>";
}
$html .= '</table><p style="text-align:right;">Generado el: ' . date('d/m/Y H:i') . '</p>';

// --- Conversión a PDF (LibreOffice Headless) ---
$tmp = "/tmp/rep_" . uniqid();
file_put_contents("$tmp.html", $html);
exec("libreoffice --headless --convert-to pdf $tmp.html --outdir /tmp");

if (file_exists("$tmp.pdf")) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="Reporte.pdf"');
    readfile("$tmp.pdf");
    unlink("$tmp.pdf");
}
unlink("$tmp.html");
exit;
?>
