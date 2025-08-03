<?php
require_once '../App/Controlador/reporteControlador.php'; // Importa el controlador para consultar ventas y registrar informes
require_once '../../vendor/autoload.php'; // Carga automática de clases, necesario para Dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

// ⚙️ Configuración para mostrar errores durante el desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ Verifica que el método HTTP sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método no permitido
    exit;
}

// 📥 Obtención de datos enviados por el formulario
$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin = $_POST['fecha_fin'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';

// ❌ Validación: campos de fechas obligatorios
if (!$fecha_inicio || !$fecha_fin) {
    error_log("❌ Fechas vacías en el formulario.");
    exit;
}

// 📊 Consultar ventas por rango de fecha
$controlador = new ReporteControlador();
[$ventas, $total] = $controlador->consultarPorFecha($fecha_inicio, $fecha_fin);

// ❌ Validación: si no hay resultados de ventas
if (empty($ventas)) {
    error_log("❌ No hay ventas para el rango {$fecha_inicio} - {$fecha_fin}");
    exit;
}

// 🔐 Validación de sesión e identificación de usuario administrador
session_start();
$idAdmin = $_SESSION['usuario']['id_usuario'] ?? null;

if (!$idAdmin) {
    error_log("⚠️ ID de usuario no encontrado en sesión.");
    exit;
}

// 📝 Registrar el informe en la base de datos
$controlador->registrarInforme($fecha_inicio, $fecha_fin, $descripcion, $idAdmin);

// 🖨️ Generar el HTML para el PDF
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { text-align: center; color: #333; }
        p { font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .descripcion { margin-top: 10px; font-style: italic; }
    </style>
</head>
<body>
    <h2>📄 Reporte de ventas</h2>
    <p><strong>Rango de fechas:</strong> <?= htmlspecialchars($fecha_inicio) ?> al <?= htmlspecialchars($fecha_fin) ?></p>

    <?php if (!empty($descripcion)): ?>
        <p class="descripcion">📝 <strong>Descripción:</strong> <?= htmlspecialchars($descripcion) ?></p>
    <?php endif; ?>

    <p><strong>Total de ventas:</strong> <?= count($ventas) ?></p>
    <p><strong>Ganancia total:</strong> $<?= number_format($total, 0, ',', '.') ?></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?= htmlspecialchars($venta['id']) ?></td>
                    <td><?= htmlspecialchars($venta['nombre']) ?></td>
                    <td><?= htmlspecialchars($venta['fecha']) ?></td>
                    <td>$<?= number_format($venta['total'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$html = ob_get_clean();

// ❌ Validación: verificar que se generó contenido HTML
if (empty(trim($html))) {
    error_log("❌ HTML vacío generado.");
    exit;
}

// ⚙️ Configuración de Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true); // Permitir recursos externos (por ejemplo, imágenes remotas)
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Orientación vertical
$dompdf->render();

// 📎 Preparar el nombre del archivo PDF para descarga
$filename = "Reporte_Ventas_{$fecha_inicio}_a_{$fecha_fin}.pdf";

// 🧹 Limpiar cualquier buffer previo antes de enviar el archivo
while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdfOutput = $dompdf->output();

// 📤 Enviar encabezados y PDF al navegador
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($pdfOutput));
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

echo $pdfOutput;
exit;

