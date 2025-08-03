<?php
require_once '../App/Controlador/PedidoControlador.php'; // ✅ Se incluye el controlador de pedidos

$controlador = new PedidoControlador(); // ✅ Se instancia el controlador

// ✅ Si la petición es POST y se ha enviado el botón 'realizar', se ejecuta el método guardar()
// Esto suele ocurrir al confirmar un pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['realizar'])) {
    $controlador->guardar();
} else {
    // ✅ Si no es POST o no se envió 'realizar', se carga la vista para crear un nuevo pedido
    $controlador->crear();
}
?>
