<?php
session_start();
require_once '../App/Modelo/Producto.php'; // ✅ Carga el modelo del producto

$producto = new Producto();
$productos = $producto->obtenerTodos(); // ✅ Consulta todos los productos

$mensaje = '';

// ✅ Verifica si el carrito está inicializado en sesión
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// ✅ Procesa la solicitud POST al agregar un producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'], $_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = intval($_POST['cantidad']); // ✅ Asegura que la cantidad sea entera

    // ✅ Si ya existe el producto en el carrito, suma cantidades
    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto] += $cantidad;
    } else {
        $_SESSION['carrito'][$id_producto] = $cantidad;
    }

    $mensaje = "✅ Producto agregado al carrito";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Catálogo de productos</title>
  
  <!-- ✅ Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .producto-card img {
      height: 180px;
      object-fit: cover;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
   <?php if (!empty($mensaje)): ?>
  <div id="mensaje-alerta" class="alert alert-success text-center" role="alert">
      <?= $mensaje ?> <!-- ✅ Muestra mensaje si se agregó producto -->
  </div>
<?php endif; ?>
    <h2 class="text-center mb-4">🛍️ Catálogo de productos</h2>
    
    <!-- ✅ Botón para ver el carrito -->
    <div class="text-center mb-4">
  <a href="carrito.php" class="btn btn-outline-primary">
    🧾 Ver carrito de compras
  </a>
</div>
    
    <div class="row">
      <?php foreach ($productos as $p): ?> <!-- ✅ Itera productos -->
        <div class="col-md-4 mb-4">
          <div class="card producto-card shadow-sm">
            <?php if (!empty($p['Foto'])): ?>
              <!-- ✅ Muestra imagen del producto -->
              <img src="data:image/jpeg;base64,<?= base64_encode($p['Foto']) ?>" class="card-img-top" alt="Foto del producto">
            <?php else: ?>
              <!-- ✅ Imagen por defecto si no hay foto -->
              <img src="https://via.placeholder.com/300x180?text=Sin+imagen" class="card-img-top" alt="Sin imagen">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($p['Nombre_Producto']) ?></h5>
              <p class="card-text">💲<?= number_format($p['Precio_venta'], 0, ',', '.') ?></p>
              
              <!-- ✅ Formulario para agregar al carrito -->
              <form method="POST" action="catalogo.php">
                <input type="hidden" name="id_producto" value="<?= $p['Id_Producto'] ?>">
                <input type="number" name="cantidad" value="1" min="1" max="<?= $p['Cantidad_en_Stock'] ?>" class="form-control mb-2" required>
                <button type="submit" class="btn btn-success w-100">➕ Agregar al carrito</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
      <!-- ✅ Botón para volver al panel -->
      <a href="usuario.php" class="btn btn-secondary">← Volver al panel</a>
    </div>
  </div>

  <!-- ✅ Script para ocultar alerta después de 3 segundos -->
  <script>
  setTimeout(() => {
    const alerta = document.getElementById('mensaje-alerta');
    if (alerta) {
      alerta.style.transition = 'opacity 0.5s ease';
      alerta.style.opacity = '0';
      setTimeout(() => alerta.remove(), 500); // eliminar del DOM
    }
  }, 3000);
</script>
</body>
</html>
