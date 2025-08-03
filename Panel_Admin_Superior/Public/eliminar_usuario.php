<?php
require_once '../App/Controlador/UsuarioControlador.php';  // ✅ Incluir el archivo del controlador de usuarios

// ✅ Verificar si se ha pasado un ID por medio de GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];  // ✅ Almacenar el ID recibido por GET

    $controlador = new UsuarioControlador();  // ✅ Crear una instancia del controlador
    $resultado = $controlador->eliminar($id); // ✅ Ejecutar la función para eliminar al usuario con ese ID

    // ❗ Podrías redirigir o mostrar un mensaje aquí después de eliminar si lo deseas

} else {
    // ⚠️ Si no se pasó un ID por la URL, redirige a la página con un mensaje de error
    header("Location: usuarios.php?error=id_faltante");
    exit;
}

