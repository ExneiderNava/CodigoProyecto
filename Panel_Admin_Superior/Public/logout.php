<?php
session_start(); // ✅ Inicia la sesión actual para poder manipularla
session_unset(); // ✅ Limpia todas las variables de sesión activas
session_destroy(); // ✅ Destruye por completo la sesión del usuario

header("Location: login_Form.php"); // ✅ Redirige al formulario de inicio de sesión
exit; // ✅ Asegura que el script se detenga inmediatamente después de redirigir
