<?php
// incluye el archivo que contiene la clase de conexion a la base de datos
require_once __DIR__ . '/../Centro/DataBase.php';

class Login {
    // propiedad para almacenar la conexion a la base de datos
    private $db;

    // constructor: se ejecuta al crear un objeto de la clase login
    public function __construct() {
        // se obtiene la conexion desde la clase DataBase
        $this->db = (new DataBase())->conn;
    }

     /**
     * Función para validar si un usuario existe con el correo y celular ingresado.
     * Retorna un array asociativo con los datos del usuario si existe,
     * o null si no hay coincidencia.
     */

    public function validarUsuario($correo, $celular): ?array {
        // prepara una conculta segura
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usuarios.Correo_Electronico = ? AND usuarios.Celular = ?");
        // ejecuta la consulta con los valores proporcionados
        $stmt->execute([$correo, $celular]);
        //obtiene el resultado como un array asociativo
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        //si no encontro nada, retorna null; si se encontro un usuario, retorna el array con sus datos
    return $resultado === false ? null : $resultado;
    }
}