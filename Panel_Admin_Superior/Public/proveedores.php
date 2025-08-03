<?php
require_once '../App/Controlador/ProveedorControlador.php'; // ✅ Incluye el controlador del proveedor
$controlador = new ProveedorControlador(); // ✅ Crea instancia del controlador

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $resultado = $controlador->guardar(); // ✅ Intenta guardar el proveedor
    $mensaje = $resultado ? 'exito' : 'error'; // ✅ Define mensaje según resultado
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Proveedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="text-center mb-4">🚚 Registrar nuevo proveedor</h2>

  <!-- Mensajes -->
  <?php if ($mensaje === 'exito'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      ✅ <strong>Proveedor registrado correctamente.</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    <div class="d-flex justify-content-center gap-3 mb-4">
      <a href="admin.php" class="btn btn-primary">← Volver al panel del administrador</a>
      <a href="proveedores.php" class="btn btn-success">➕ Registrar otro proveedor</a>
    </div>
  <?php elseif ($mensaje === 'error'): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      ❌ <strong>Error al registrar el proveedor.</strong> Intenta nuevamente.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  <?php endif; ?>

  <!-- Formulario -->
  <form action="" method="POST" class="bg-white p-4 shadow rounded">
    <div class="mb-3">
      <input type="text" name="nombre" class="form-control" placeholder="Nombre del proveedor" required>
    </div>

    <div class="mb-3">
      <input type="number" name="celular" class="form-control" placeholder="Celular" required>
      <!-- ❌ Validar en el backend que el celular no tenga más de 10 dígitos si aplica a tu país -->
    </div>

    <div class="mb-3">
      <input type="email" name="correo_electronico" class="form-control" placeholder="Correo electrónico" required>
      <!-- ❌ Validar en el backend si el correo ya existe para evitar duplicados -->
    </div>

    <button type="submit" name="crear" class="btn btn-primary w-100">✅ Registrar proveedor</button>
  </form>
</div>

<div class="text-center mt-4">
  <a href="admin.php" class="btn btn-secondary">← Volver al panel del administrador</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

