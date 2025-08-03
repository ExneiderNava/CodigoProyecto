<?php
require_once '../App/Controlador/ProductoControlador.php'; // ✅ Se incluye el controlador de productos

$controlador = new ProductoControlador(); // ✅ Se crea una instancia del controlador

$controlador->crear(); // ✅ Se llama al método crear() que debe mostrar la vista Producto/crear.php
// ❗ Asegúrate de que la ruta ../Vista/Producto/crear.php exista para evitar errores
?>
