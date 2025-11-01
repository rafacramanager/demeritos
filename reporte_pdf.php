<?php
session_start();
require 'db.php';

// 🔹 Cargar Dompdf sin Composer
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$codigo_infra = $_SESSION['codigo_infra'] ?? '';
$ce = $_SESSION['centro_educativo'] ?? '';

if (!$codigo_infra || !$ce) {
  die("❌ No hay datos de sesión. Inicie sesión nuevamente.");
}

// Filtros desde GET
$filtro_fecha = $_GET['fecha'] ?? '';
$filtro_grado = $_GET['grado'] ?? '';
$filtro_seccion = $_GET['seccion'] ?? '';
$filtro_turno = $_GET['turno'] ?? '';
$filtro_nie = $_GET['nie'] ?? '';

// Construir consulta filtrada
$sql = "SELECT * FROM estudiantes WHERE codigo_infra = '$codigo_infra'";
if ($filtro_fecha)   $sql .= " AND fecha = '$filtro_fecha'";
if ($filtro_grado)   $sql .= " AND grado LIKE '%$filtro_grado%'";
if ($filtro_seccion) $sql .= " AND seccion LIKE '%$filtro_seccion%'";
if ($filtro_turno)   $sql .= " AND turno = '$filtro_turno'";
if ($filtro_nie)     $sql .= " AND nie LIKE '%$filtro_nie%'";
$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);

// Crear contenido HTML del PDF
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
  h2 { text-align: center; color: #0d6efd; }
  table { width: 100%; border-collapse: collapse; margin-top: 10px; }
  th, td { border: 1px solid #333; padding: 5px; text-align: center; }
  th { background-color: #e3f2fd; }
  .footer { text-align: center; font-size: 10px; margin-top: 20px; color: #555; }
</style>
</head>
<body>
  <h2>📋 Informe de Deméritos</h2>';
  
// 🔹 Agregamos correctamente la información del encabezado
$html .= '<p><strong>Código de Infraestructura:</strong> ' . htmlspecialchars($codigo_infra) . '</p>';
$html .= '<p><strong>Centro Educativo:</strong> ' . htmlspecialchars($ce) . '</p>';

if ($filtro_fecha || $filtro_grado || $filtro_seccion || $filtro_turno || $filtro_nie) {
  $html .= "<p><strong>Filtros aplicados:</strong><br>";
  if ($filtro_fecha)   $html .= "Fecha: $filtro_fecha<br>";
  if ($filtro_grado)   $html .= "Grado: $filtro_grado<br>";
  if ($filtro_seccion) $html .= "Sección: $filtro_seccion<br>";
  if ($filtro_turno)   $html .= "Turno: $filtro_turno<br>";
  if ($filtro_nie)     $html .= "NIE: $filtro_nie<br>";
  $html .= "</p>";
}

$html .= '
<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Fecha</th>
      <th>NIE</th>
      <th>Nombre</th>
      <th>Grado</th>
      <th>Sección</th>
      <th>Turno</th>
      <th>Demérito</th>
    </tr>
  </thead>
  <tbody>';

$contador = 1;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
      <td>{$contador}</td>
      <td>{$row['fecha']}</td>
      <td>{$row['nie']}</td>
      <td>{$row['nombre']}</td>
      <td>{$row['grado']}</td>
      <td>{$row['seccion']}</td>
      <td>{$row['turno']}</td>
      <td>{$row['concepto']}</td>
    </tr>";
    $contador++;
  }
} else {
  $html .= "<tr><td colspan='8'>No se encontraron registros</td></tr>";
}

$html .= '
  </tbody>
</table>
<p class="footer">Generado automáticamente el ' . date("d/m/Y H:i:s") . '</p>
</body>
</html>
';

// Configurar Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); // Horizontal
$dompdf->render();

// Mostrar en el navegador (no descargar)
$dompdf->stream("reporte_demeritos.pdf", ["Attachment" => false]);

$conn->close();
?>
