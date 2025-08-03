<?php
session_start();

// ✅ Verificación de sesión y rol de administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    echo "⚠️ Acceso denegado.";
    exit;
}

// ✅ Captura segura del nombre y rol del usuario desde la sesión
$nombre = $_SESSION['usuario']['Nombres_usuario'] ?? 'Admin';
$rol = $_SESSION['usuario']['Rol'] ?? 'Administrador';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de administrador</title>
  <!-- ✅ Bootstrap para estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* ✅ Estilos generales del panel */
    body {
      background-color: #f4f6f9;
    }
    .admin-header {
      margin-top: 40px;
      text-align: center;
    }
    .admin-header h2 {
      font-weight: bold;
    }
    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
      padding: 40px;
    }
    .admin-card {
      padding: 20px;
      text-align: center;
    }
    .admin-card i {
      font-size: 2rem;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="admin-header">
      <!-- ✅ Muestra el nombre del usuario y su rol -->
      <h2>👑 Bienvenido, <?= htmlspecialchars($nombre) ?> (<?= htmlspecialchars($rol) ?>)</h2>
    </div>

    <div class="card-grid">
      <!-- ✅ Opción para registrar usuario -->
      <div class="card shadow-sm admin-card">
        <i class="bi bi-person-plus-fill text-primary"></i>
        <h5 class="mt-2">Registrar usuario</h5>
        <a href="registro_Usuario.php" class="btn btn-outline-primary btn-sm">Ir</a>
      </div>

      <!-- ✅ Opción para registrar producto -->
      <div class="card shadow-sm admin-card">
        <i class="bi bi-box-seam-fill text-warning"></i>
        <h5 class="mt-2">Registrar producto</h5>
        <a href="producto.php" class="btn btn-outline-warning btn-sm">Ir</a>
      </div>

      <!-- ✅ Opción para ver pedidos -->
      <div class="card shadow-sm admin-card">
        <i class="bi bi-card-list text-success"></i>
        <h5 class="mt-2">Ver pedidos</h5>
        <a href="ver_Pedidos.php" class="btn btn-outline-success btn-sm">Ir</a>
      </div>

      <!-- ✅ Opción para ver reportes -->
      <div class="card shadow-sm admin-card">
        <i class="bi bi-clipboard-data-fill text-info"></i>
        <h5 class="mt-2">Ver reportes</h5>
        <a href="reportes.php" class="btn btn-outline-info btn-sm">Ir</a>
      </div>

      <!-- ✅ Opción para registrar proveedores -->
      <div class="card shadow-sm admin-card">
        <i class="bi bi-truck text-dark"></i>
        <h5 class="mt-2">Registrar proveedores</h5>
        <a href="proveedores.php" class="btn btn-outline-dark btn-sm">Ir</a>
      </div>

      <!-- ✅ Opción para cerrar sesión -->
      <div class="card shadow-sm admin-card">
        <i class="bi bi-box-arrow-right text-secondary"></i>
        <h5 class="mt-2">Cerrar sesión</h5>
        <a href="logout.php" class="btn btn-outline-secondary btn-sm">Salir</a>
      </div>
    </div>
  </div>

  <!-- ✅ Carga de íconos de Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>

