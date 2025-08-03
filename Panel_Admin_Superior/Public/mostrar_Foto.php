<?php
require_once '../App/Centro/DataBase.php'; // ✅ Se incluye el archivo que establece la conexión a la base de datos

if (!isset($_GET['id'])) exit; // ✅ Si no se recibe un ID por GET, se termina el script

$db = (new DataBase())->conn; // ✅ Se instancia la clase DataBase y se obtiene la conexión PDO

$stmt = $db->prepare("SELECT Foto FROM productos WHERE Id_Producto = ?"); // ✅ Consulta preparada para evitar inyección SQL
$stmt->execute([$_GET['id']]); // ✅ Se ejecuta la consulta con el ID recibido por GET
$foto = $stmt->fetchColumn(); // ✅ Se obtiene solo la columna de la imagen (tipo BLOB)

// ❌ Verificar si el campo `Foto` contiene imágenes en otro formato distinto a JPEG,
// de lo contrario el encabezado Content-Type podría causar error al mostrarla.

if ($foto) {
    header("Content-Type: image/jpeg"); // ✅ Se envía un encabezado que indica que se mostrará una imagen JPEG
    echo $foto; // ✅ Se imprime directamente la imagen como salida binaria
}
