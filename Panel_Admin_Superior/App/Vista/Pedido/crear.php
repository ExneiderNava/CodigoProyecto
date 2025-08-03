<!-- Título principal de la página -->
<h2>Realizar pedido</h2>

<!-- Formulario para enviar un pedido -->
<!-- Usa método POST y se envía al archivo pedido.php -->
<form action="/Proyecto_F2/Public/pedido.php" method="POST">

    <!-- Bucle PHP para mostrar todos los productos disponibles -->
    <?php foreach ($productos as $producto): ?>
        <div>
            <!-- Muestra el nombre y el precio de cada producto -->
            <label><?= $producto['Nombre_Producto'] ?> (<?= $producto['Precio_venta'] ?>)</label>
            
            <!-- Campo numérico para ingresar la cantidad deseada del producto -->
            <!-- El nombre del input es un array asociativo con el ID del producto como clave -->
            <!-- Se limita el valor mínimo a 0 y el máximo a la cantidad disponible en stock -->
            <input type="number" name="productos[<?= $producto['Id_Producto'] ?>]" min="0" max="<?= $producto['Cantidad_en_Stock'] ?>" value="0">
        </div>
    <?php endforeach; ?>

    <!-- Botón para enviar el formulario y realizar el pedido -->
    <button type="submit" name="realizar">Enviar pedido</button>
    
    <br><br>
    
    <!-- Enlace para regresar al panel del administrador -->
    <a href="/Proyecto_F2/Public/admin.php">← Volver al panel del administrador</a>
</form>
