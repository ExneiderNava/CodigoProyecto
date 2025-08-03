<?php
// Verifica si la variable $pedidos está definida, si no, la inicializa como un array vacío
if (!isset($pedidos)) {
    $pedidos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración de caracteres -->
    <meta charset="UTF-8">

    <!-- Título de la pestaña del navegador -->
    <title>Pedidos realizados</title>

    <!-- Enlace al framework de estilos Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Contenedor principal con margen superior -->
<div class="container mt-5">

    <!-- Título centrado -->
    <h2 class="text-center mb-4">🧾 Pedidos realizados</h2>

    <!-- Condicional: Si no hay pedidos, se muestra un mensaje informativo -->
    <?php if (empty($pedidos)): ?>
        <div class="alert alert-info text-center">
            No hay pedidos registrados.
        </div>
    
    <!-- Si hay pedidos, se muestra la tabla con los datos -->
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nombre del usuario</th>
                        <th>ID Usuario</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <!-- Bucle que recorre todos los pedidos y los muestra en filas -->
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <!-- Se muestran los datos de cada pedido -->
                            <td><?= htmlspecialchars($pedido['id']) ?></td>
                            <td><?= htmlspecialchars($pedido['nombre']) ?></td>
                            <td><?= htmlspecialchars($pedido['id_usuario']) ?></td>
                            <td><?= htmlspecialchars($pedido['fecha']) ?></td>
                            <td><?= htmlspecialchars($pedido['estado']) ?></td>

                            <!-- Se formatea el total como moneda en formato colombiano -->
                            <td>$<?= number_format($pedido['total'], 0, ',', '.') ?></td>

                            <!-- Enlace al detalle del pedido con el ID como parámetro -->
                            <td> 
                                <a href="detalle_pedido.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-info">📄 Ver detalle</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- Botón para regresar al panel del administrador -->
    <div class="text-center mt-4">
        <a href="/Proyecto_F2/Panel_Admin_Superior/Public/admin.php" class="btn btn-secondary">← Volver al panel del administrador</a>
    </div>
</div>

<!-- Script de Bootstrap para funcionalidad interactiva -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
