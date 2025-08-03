<?php
session_start(); // ✅ Inicia la sesión para acceder a variables de sesión

// ✅ Verifica si el usuario está autenticado y si su rol es permitido (Estudiante o Profesor)
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['Rol'], ['Estudiante', 'Profesor'])) {
    echo "⚠️ Acceso denegado."; // ❌ Si no cumple la condición, muestra mensaje y termina la ejecución
    exit;
}

// ✅ Se obtienen los datos del usuario desde la sesión, si están definidos
$nombre = $_SESSION['usuario']['Nombres_usuario'] ?? 'Usuario';
$rol    = $_SESSION['usuario']['Rol'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Usuario</title>
  <!-- ✅ Se importa Bootstrap para estilos responsivos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* ✅ Estilo para el fondo y efecto hover en las tarjetas */
    body {
      background-color: #f4f6f9;
    }
    .card-opcion {
      transition: transform 0.2s ease;
    }
    .card-opcion:hover {
      transform: scale(1.03);
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <!-- ✅ Encabezado de bienvenida con el nombre y rol del usuario -->
    <div class="text-center mb-4">
      <h2>👋 Bienvenido, <?= htmlspecialchars($nombre) ?> (<?= htmlspecialchars($rol) ?>)</h2>
      <p class="text-muted">Selecciona una opción para continuar:</p>
    </div>

    <div class="row justify-content-center">
      <!-- ✅ Opción para ir al catálogo de productos -->
      <div class="col-md-4 mb-3">
        <div class="card card-opcion shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">🛒 Ver catálogo</h5>
            <a href="catalogo.php" class="btn btn-primary">Ir al catálogo</a>
          </div>
        </div>
      </div>

      <!-- ✅ Opción para ver el carrito de compras -->
      <div class="col-md-4 mb-3">
        <div class="card card-opcion shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">🧾 Ver carrito</h5>
            <a href="carrito.php" class="btn btn-success">Ir al carrito</a>
          </div>
        </div>
      </div>

      <!-- ✅ Opción para cerrar sesión -->
      <div class="col-md-4 mb-3">
        <div class="card card-opcion shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">🚪 Cerrar sesión</h5>
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
