<?php
// Se incluye el archivo de conexión a la base de datos
require_once '../App/Centro/DataBase.php';

// Se obtiene la conexión a la base de datos
$db = (new DataBase())->conn;

// Se capturan los datos enviados por POST desde el formulario
$id      = $_POST['Id_Producto'];
$nombre  = $_POST['Nombre_Producto'];
$precio_costo = $_POST['Precio_costo'];
$precio_venta = $_POST['Precio_venta'];
$cantidad     = $_POST['Cantidad_en_Stock'];
$categoria    = $_POST['Tipo_Producto'];

// Si el usuario subió una nueva imagen del producto
if (!empty($_FILES['foto']['tmp_name'])) {
    // Se obtiene el contenido binario de la imagen
    $foto = file_get_contents($_FILES['foto']['tmp_name']);

    // Se crea la consulta SQL para actualizar el producto incluyendo la imagen
    $sql = "UPDATE productos SET 
        productos.Nombre_Producto = ?, 
        productos.Precio_costo = ?, 
        productos.Precio_venta = ?, 
        productos.Cantidad_en_Stock = ?, 
        productos.Tipo_Producto = ?, 
        productos.Foto = ?
        WHERE productos.Id_Producto = ?";
        
    // Se prepara y ejecuta la sentencia SQL con los datos del formulario
    $stmt = $db->prepare($sql);
    $stmt->execute([$nombre, $precio_costo, $precio_venta, $cantidad, $categoria, $foto, $id]);
} else {
    // Si no se sube nueva imagen, se actualizan los demás campos sin tocar la imagen
    $sql = "UPDATE productos SET 
        productos.Nombre_Producto = ?, 
        productos.Precio_costo = ?, 
        productos.Precio_venta = ?, 
        productos.Cantidad_en_Stock = ?, 
        productos.Tipo_Producto = ?
        WHERE productos.Id_Producto = ?";
        
    // Se prepara y ejecuta la sentencia SQL sin la imagen
    $stmt = $db->prepare($sql);
    $stmt->execute([$nombre, $precio_costo, $precio_venta, $cantidad, $categoria, $id]);
}

// Una vez actualizado, se redirige al formulario con parámetro de éxito
header("Location: producto.php?listar=1");
exit;
