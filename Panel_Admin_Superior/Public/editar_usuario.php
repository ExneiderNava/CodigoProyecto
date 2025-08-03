<?php
require_once '../App/Controlador/UsuarioControlador.php';  // ✅ Incluir el controlador del usuario

$controlador = new UsuarioControlador();  // ✅ Crear instancia del controlador

// ✅ Verifica si la acción es 'actualizar' para guardar cambios en la base de datos
if (isset($_GET['accion']) && $_GET['accion'] === 'actualizar') {
    $controlador->actualizar();  // 👈 Ejecutar la función que guarda en la base de datos
} else {
    $controlador->editar();      // 👈 Mostrar el formulario de edición
}


