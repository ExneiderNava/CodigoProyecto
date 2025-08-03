<?php
require_once '../App/Controlador/LoginControlador.php'; // ✅ Incluye el controlador responsable de la lógica de login

$login = new LoginControlador(); // ✅ Crea una instancia del controlador de login
$login->autenticar(); // ✅ Llama al método que se encarga de verificar el usuario y redirigir si es válido

?>
