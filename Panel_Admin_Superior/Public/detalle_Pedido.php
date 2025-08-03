<?php
require_once '../App/Centro/DataBase.php'; // ✅ Se incluye la clase de conexión a la base de datos

// ❌ Validación: si no se proporciona un ID por GET, se muestra un mensaje de error y se termina la ejecución
if (!isset($_GET['id'])) {
    echo "❌ ID de pedido no proporcionado.";
    exit;
}

$id_pedido = $_GET['id'];
$db = (new DataBase())->conn; // ✅ Se obtiene la conexión a la base de datos

// ✅ Consulta para obtener los datos del pedido (usuario, fecha, total)
$stmt_pedido = $db->prepare("
    SELECT ventas_pedidos.Id, usuarios.Nombres_usuario AS usuario, ventas_pedidos.Fecha_Venta, ventas_pedidos.total 
    FROM ventas_pedidos 
    JOIN usuarios ON ventas_pedidos.id_usuario = usuarios.Id_usuario 
    WHERE ventas_pedidos.Id = ?
");
$stmt_pedido->execute([$id_pedido]);
$pedido = $stmt_pedido->fetch(PDO::FETCH_ASSOC); // ✅ Se obtiene un solo resultado (un pedido)

// ✅ Consulta para obtener los detalles del pedido: productos, cantidad y precio
$stmt_detalles = $db->prepare("
    SELECT detalles_pedido.cantidad, productos.Nombre_Producto, productos.Precio_venta 
    FROM detalles_pedido 
    JOIN productos ON detalles_pedido.id_producto = productos.Id_Producto 
    WHERE detalles_pedido.id_pedido = ?
");
$stmt_detalles->execute([$id_pedido]);
$detalles = $stmt_detalles->fetchAll(PDO::FETCH_ASSOC); // ✅ Se obtienen todos los productos del pedido
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Pedido</title>
  <!-- ✅ Bootstrap para estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <!-- ✅ Información principal del pedido -->
  <h2 class="mb-4">📦 Detalle del Pedido #<?= htmlspecialchars($pedido['Id']) ?></h2>
  <p><strong>👤 Cliente:</strong> <?= htmlspecialchars($pedido['usuario']) ?></p>
  <p><strong>🗓 Fecha:</strong> <?= htmlspecialchars($pedido['Fecha_Venta']) ?></p>
  <p><strong>💵 Total:</strong> $<?= number_format($pedido['total'], 0, ',', '.') ?></p>

  <!-- ✅ Tabla de productos -->
  <table class="table table-bordered mt-4">
    <thead class="table-dark">
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($detalles as $d): ?>
        <tr>
          <!-- ✅ Se usa htmlspecialchars para evitar inyección de HTML -->
          <td><?= htmlspecialchars($d['Nombre_Producto']) ?></td>
          <td><?= $d['cantidad'] ?></td>
          <td>$<?= number_format($d['Precio_venta'], 0, ',', '.') ?></td>
          <td>$<?= number_format($d['Precio_venta'] * $d['cantidad'], 0, ',', '.') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- ✅ Botón para volver a la lista de pedidos -->
  <a href="ver_Pedidos.php" class="btn btn-secondary mt-3">← Volver a la lista de pedidos</a>
</div>
</body>
</html>
