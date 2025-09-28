<?php
require_once '../App/Controlador/ProductoControlador.php'; // ✅ Se incluye el controlador de productos

$controlador = new ProductoControlador(); // ✅ Se crea una instancia del controlador

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'editar') {
    $controlador->editar(); // ✅ Llama al método editar() del controlador
    header('Location: producto.php?mensaje=editado'); // ✅ Redirige para evitar reenvío de formulario
    exit;
}


$controlador->crear(); // ✅ Se llama al método crear() que debe mostrar la vista Producto/crear.php
// ❗ Asegúrate de que la ruta ../Vista/Producto/crear.php exista para evitar errores
?>
