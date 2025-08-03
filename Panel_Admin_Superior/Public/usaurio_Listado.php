<?php
session_start(); // ✅ Se inicia la sesión para poder acceder a variables de sesión si es necesario

// ✅ Mensaje de confirmación al registrar un usuario
echo "✅ Usuario registrado correctamente.<br>";

// ✅ Enlace para volver al formulario de usuarios
echo "<a href='usuario.php'>Volver al formulario</a>";
?>
