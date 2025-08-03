<?php
require_once '../App/Controlador/ReporteControlador.php'; // Cargamos el controlador
$controlador = new ReporteControlador();

$ventas = [];  // Lista de ventas por fecha
$total = 0;    // Total sumado

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // ❌ Asegúrate que las fechas se estén validando correctamente antes de enviarlas al controlador

    // Consultamos ventas entre fechas y obtenemos lista y total
    [$ventas, $total] = $controlador->consultarPorFecha($fecha_inicio,$fecha_fin);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reportes de ventas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="text-center mb-4">📊 Reportes de ventas</h2>

    <!-- Formulario para elegir rango de fechas -->
    <form method="POST" class="mb-4">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <label>Fecha Inicio</label>
          <input type="date" name="fecha_inicio" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label>Fecha fin</label>
          <input type="date" name="fecha_fin" class="form-control" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100">Consultar</button>
        </div>
      </div>
    </form>

    <!-- Se muestra solo si hay ventas -->
    <?php if (count($ventas) > 0): ?>    
      <div class="card">
        <div class="card-header bg-success text-white">Resultados</div>
        <div class="card-body">
          <p>🧾 Total de ventas realizadas: <strong><?= count($ventas) ?></strong></p>
          <p>💰 Ganancia total: <strong>$<?= number_format($total, 0, ',', '.') ?></strong></p>

          <!-- Tabla con resultados -->
          <table class="table table-striped">
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
                  <td><?= $venta['id'] ?></td>
                  <td><?= $venta['nombre'] ?></td>
                  <td><?= $venta['fecha'] ?></td>
                  <td>$<?= number_format($venta['total'], 0, ',', '.') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <!-- Botón que abre el modal -->
          <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#modalDescripcion">
            📄 Descargar Reporte
          </button>
        </div>
      </div>

      <!-- Modal donde se escribe descripción del reporte -->
      <div class="modal fade" id="modalDescripcion" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form method="POST" action="generar_pdf.php" target="_blank">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Descripción del reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="descripcion" class="form-label">Agrega una descripción</label>
                  <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                </div>
                <!-- Envío oculto de las fechas -->
                <input type="hidden" name="fecha_inicio" value="<?= htmlspecialchars($fecha_inicio) ?>">
                <input type="hidden" name="fecha_fin" value="<?= htmlspecialchars($fecha_fin) ?>">
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Generar PDF</button>
              </div>
            </div>
          </form>
        </div>
      </div>

    <!-- Si no se encontraron ventas -->
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
      <div class="alert alert-warning text-center">No se encontraron ventas para esa fecha.</div>
    <?php endif; ?>
    
    <!-- Botón para volver -->
    <div class="mt-4">
      <a href="admin.php" class="btn btn-secondary">← Volver al panel del administrador</a>
    </div>
  </div>

  <!-- Scripts de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
