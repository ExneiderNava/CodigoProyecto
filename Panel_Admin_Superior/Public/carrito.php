<?php
session_start();
require_once '../App/Modelo/Producto.php';

// Obtener todos los productos disponibles
$productoModel = new Producto();
$productosDisponibles = $productoModel->obtenerTodos();

$productos = [];
$total = 0;

// Verificamos si el carrito existe
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    $carritoVacio = true;
} else {
    $carritoVacio = false;

    // Crear un array asociativo con los productos por ID
    foreach ($productosDisponibles as $prod) {
        $productos[$prod['Id_Producto']] = $prod;
    }

    // Eliminar producto si se recibió el id para eliminar
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
        $idEliminar = $_POST['eliminar_id'];

        // ❌ Posible fallo si el ID no existe en el carrito (aunque poco probable)
        unset($_SESSION['carrito'][$idEliminar]);
        header("Location: carrito.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">🛒 Carrito de compras</h2>

        <?php if ($carritoVacio): ?>
            <div class="alert alert-warning text-center">
                Tu carrito está vacío.
            </div>
            <div class="text-center mt-3">
                <a href="usuario.php" class="btn btn-primary">← Volver al menú</a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($_SESSION['carrito'] as $id => $cantidad): 
                    $prod = $productos[$id] ?? null;
                    if (!$prod) continue; // ❌ Silenciosamente ignora el error si el ID ya no existe en base

                    $subtotal = $cantidad * $prod['Precio_venta'];
                    $total += $subtotal;
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="row g-0">
                            <div class="col-4">
                                <?php if (!empty($prod['Foto'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($prod['Foto']) ?>" class="img-fluid rounded-start" alt="Imagen">
                                    // ✅ Correcto: Se renderiza imagen desde base64
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/150x150?text=Sin+imagen" class="img-fluid rounded-start" alt="Sin imagen">
                                <?php endif; ?>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($prod['Nombre_Producto']) ?></h5>
                                    // ✅ Se sanitiza correctamente para evitar XSS

                                    <p class="card-text">💲 <?= number_format($prod['Precio_venta'], 0, ',', '.') ?></p>
                                    <p class="card-text">Cantidad: <?= $cantidad ?></p>
                                    <p class="card-text fw-bold">Subtotal: $<?= number_format($subtotal, 0, ',', '.') ?></p>

                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="eliminar_id" value="<?= $id ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">🗑️ Eliminar</button>
                                    </form>
                                    // ✅ Eliminar individual con POST seguro
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center">
                <h4 class="mb-3">💰 Total: $<?= number_format($total, 0, ',', '.') ?></h4>
                <a href="catalogo.php" class="btn btn-secondary me-2">← Seguir comprando</a>
                <a href="confirmar_pedido.php" class="btn btn-success">✅ Confirmar pedido</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
