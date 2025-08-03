<!-- Título de la sección -->
<h2>Productos registrados</h2>

<!-- Tabla para mostrar los productos -->
<table border="1">
    <tr>
        <!-- Encabezados de la tabla -->
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio de costo</th>
        <th>Precio de venta</th>
        <th>Cantidad</th>
    </tr>

    <?php 
    // Recorre el array de productos y los muestra uno por uno
    foreach ($productos as $p): 
    ?>
        
    <tr>
        <!-- Celdas con los datos del producto -->
        <td><?= $p['Id_Producto'] ?></td>
        <td><?= $p['Nombre_Producto'] ?></td>
        <td><?= $p['Precio_costo']?></td>
        <td><?= $p['Precio_venta'] ?></td>
        <td><?= $p['Cantidad_en_Stock'] ?></td>

        <!-- Enlace para editar el producto -->
        <td><a href="editar_producto.php?id=<?= $p['Id_Producto'] ?>">✏️ Editar</a></td>
    </tr>

    <?php endforeach; ?>
</table>

<br>

<!-- Enlace para regresar al formulario de registro de producto -->
<a href="/Proyecto_F2/Public/producto.php">← Volver al formulario</a>
