<?php
require_once '../App/Centro/DataBase.php';

$db = (new DataBase())->conn;

// Obtener ID del producto por GET
if (!isset($_GET['id'])) {
    echo "⚠️ No se especificó el ID del producto.";
    exit;
}

$id = $_GET['id']; // ❌ Revisión sugerida: podrías validar que $id sea numérico para mayor seguridad.
$stmt = $db->prepare("SELECT * FROM productos WHERE Id_Producto = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    echo "❌ Producto no encontrado.";
    exit;
}
?>

<h2>✏️ Editar producto: <?= htmlspecialchars($producto['Nombre_Producto']) ?></h2>

<form action="actualizar_producto.php" method="POST" enctype="multipart/form-data">
    <!-- Campo oculto con el ID del producto -->
    <input type="hidden" name="Id_Producto" value="<?= $producto['Id_Producto'] ?>">

    <!-- Campo para el nombre del producto -->
    <label>Nombre:</label><br>
    <input type="text" name="Nombre_Producto" value="<?= htmlspecialchars($producto['Nombre_Producto']) ?>" required><br><br>

    <!-- Campo para el precio de costo -->
    <label>Precio de costo:</label><br>
    <input type="number" name="Precio_costo" value="<?= $producto['Precio_costo'] ?>" required><br><br>

    <!-- Campo para el precio de venta -->
    <label>Precio de venta:</label><br>
    <input type="number" name="Precio_venta" value="<?= $producto['Precio_venta'] ?>" required><br><br>

    <!-- Campo para la cantidad disponible en stock -->
    <label>Cantidad en stock:</label><br>
    <input type="number" name="Cantidad_en_Stock" value="<?= $producto['Cantidad_en_Stock'] ?>" required><br><br>

    <!-- ❌ Campo para categoría: aquí solo se muestra el número, podrías usar un select con nombre de categorías -->
    <label>Categoría:</label><br>
    <input type="number" name="Tipo_Producto" value="<?= $producto['Tipo_Producto'] ?>" required><br><br>

    <!-- Mostrar imagen actual del producto -->
    <label>Foto actual:</label><br>
    <img src="mostrar_foto.php?id=<?= $producto['Id_Producto'] ?>" width="100"><br><br>

    <!-- Campo para subir nueva imagen (opcional) -->
    <label>Nueva foto (opcional):</label><br>
    <input type="file" name="Foto" accept="image/*"><br><br>

    <!-- Botón para enviar el formulario -->
    <button type="submit">💾 Actualizar producto</button>
</form>

<br>
<!-- Enlace para volver al listado -->
<a href="producto.php?listar=1">← Volver al listado de productos</a>
