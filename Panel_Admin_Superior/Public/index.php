<?php
require_once '../App/Centro/Controlador.php'; // ✅ Incluye el archivo base del controlador

// Obtener el controlador y método por URL
$controlador = $_GET['controlador'] ?? 'UsuarioControlador'; // ✅ Usa controlador por defecto si no se pasa por URL
$metodo = $_GET['metodo'] ?? 'index'; // ✅ Usa método por defecto si no se pasa por URL

// Ruta del controlador
$archivoControlador = "../App/Controlador/" . $controlador . ".php"; // ✅ Construye ruta completa del controlador

if (file_exists($archivoControlador)) { // ✅ Verifica si el archivo existe
    require_once $archivoControlador; // ✅ Incluye el archivo del controlador solicitado
    $obj = new $controlador(); // ✅ Crea instancia del controlador

    if (method_exists($obj, $metodo)) { // ✅ Verifica que el método exista en el controlador
        $obj->$metodo(); // ✅ Ejecuta el método dinámicamente
    } else {
        echo "Método '$metodo' no encontrado."; // ❌ Si no existe el método, muestra mensaje pero no detiene ejecución
        // ❌ Falta un exit aquí para evitar que continúe con la redirección
    }
} else {
    echo "Controlador '$controlador' no encontrado."; // ❌ Si no existe el controlador, muestra mensaje pero no detiene ejecución
    // ❌ Falta un exit aquí también
}

header('Location: login_form.php'); // ❌ Esta redirección siempre se ejecuta, incluso si hubo errores arriba
exit;
?>
