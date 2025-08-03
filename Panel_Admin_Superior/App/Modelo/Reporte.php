<?php
//incluye la clase encargada de establecer la conexion a la base de datos
require_once __DIR__ . '/../Centro/DataBase.php';

class Reporte {

    // propiedad que almacenara la conexion a la base de datos
    private $db;

    // contructor: se ejecuta automaticamente al crear una instancia de esta clase
    public function __construct() {
        // se obtiene la conexion PDO desde la clase DataBase
        $this->db = (new DataBase())->conn;
    }

    /**
     * Obtiene todas las ventas realizadas en una fecha específica.
     * @param string $fecha - La fecha seleccionada por el usuario (formato: 'YYYY-MM-DD')
     * @return array - Devuelve un array con dos elementos:
     *                 [0] => lista de ventas realizadas ese día
     *                 [1] => suma total de todas esas ventas
     */

    public function obtenerVentasPorFecha($fecha_inicio, $fecha_fin) {
    // prepara una consulta SQL para seleccionar ventas de la fecha indicada    
    $stmt = $this->db->prepare("
        SELECT 
            ventas_pedidos.Id AS id,
            usuarios.Nombres_usuario AS nombre,
            ventas_pedidos.Fecha_Venta AS fecha,
            ventas_pedidos.total
        FROM ventas_pedidos
        JOIN usuarios ON ventas_pedidos.id_usuario = usuarios.Id_usuario
        WHERE DATE(ventas_pedidos.Fecha_Venta) BETWEEN ? AND ?;
    ");

    //ejecuta la consulta con la fecha recibida
    $stmt->execute([$fecha_inicio, $fecha_fin]);
    //obtiene todas las ventas encontradas (como arreglo asociativo)
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcula la suma total de las ventas del dia
    //extrae todos los valores de la columna total y los suma
    $total = array_sum(array_column($ventas, 'total'));

    //devuelve un arreglo con:
    // - la lista completa de ventas
    // - el total sumado

    return [$ventas, $total];
}


// con esta funcion se guarda el informe al descargar el pdf en la base de datos
public function guardarInforme($fecha_inicio, $fecha_fin, $descripcion, $idAdmin){
    $stmt = $this->db->prepare("INSERT INTO informes (fecha_inicio, fecha_final, descripcion, id_admin)
        VALUES (?, ?, ?, ?)");
    return $stmt->execute([$fecha_inicio, $fecha_fin, $descripcion, $idAdmin]);
}




}