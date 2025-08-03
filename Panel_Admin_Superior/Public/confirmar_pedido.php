<?php
session_start();
require_once '../App/Modelo/Pedido.php'; // ⚠️ Asegúrate de que la ruta y clase Pedido sean correctas

$pedido = new Pedido(); // ⚠️ Verifica que la clase Pedido esté correctamente definida
$id_usuario = $_SESSION['usuario']['Id_usuario'] ?? null; // ⚠️ Asegúrate de que la sesión contenga 'usuario' y 'Id_usuario'
$productos = $_SESSION['carrito'] ?? []; // ⚠️ Asegúrate de que el carrito esté bien estructurado como arreglo

$mensaje = '';
if ($id_usuario && !empty($productos)) {
    $resultado = $pedido->crearPedido($id_usuario, $productos); // ⚠️ Revisa que crearPedido maneje correctamente validaciones e inserciones
    if ($resultado) {
        $mensaje = '✅ Pedido confirmado correctamente.';
        unset($_SESSION['carrito']); // ⚠️ Esto limpia el carrito tras confirmación
    } else {
        $mensaje = '❌ Error al confirmar el pedido.'; // ❌ Puede que el método crearPedido no devuelva false correctamente, validar internamente
    }
} else {
    $mensaje = '⚠️ No hay productos en el carrito o no estás logueado.'; // ⚠️ Este mensaje aparece si no hay sesión o carrito
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Confirmación de pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- ⚠️ Asegúrate de tener conexión a internet para cargar Bootstrap -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    .mensaje {
      margin-top: 50px;
    }
  </style>
</head>
<body>
  <div class="container mensaje text-center">
    <div class="alert <?= str_contains($mensaje, '✅') ? 'alert-success' : 'alert-danger' ?> fw-bold" role="alert">
      <?= $mensaje ?> <!-- ⚠️ Se muestra el resultado de la operación -->
    </div>

    <div class="mt-4">
      <a href="catalogo.php" class="btn btn-outline-primary me-2">← Volver al catálogo</a> <!-- ⚠️ Asegúrate de que 'catalogo.php' exista -->
      <a href="usuario.php" class="btn btn-outline-secondary">🏠 Volver al panel del usuario</a> <!-- ⚠️ Asegúrate de que 'usuario.php' exista -->
    </div>
  </div>
</body>
</html>
