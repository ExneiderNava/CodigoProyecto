<?php
require_once __DIR__ . '/../Centro/DataBase.php';

class ProveedorModelo {
    private $db;

    public function __construct() {
        $this->db = (new DataBase())->conn;
    }

    public function insertarProveedor($nombre, $celular, $correo_electronico) {
        try {
            $sql = "INSERT INTO proveedores (nombre, celular, correo_electronico)
                    VALUES (:nombre, :celular, :correo)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':celular', $celular);
            $stmt->bindParam(':correo', $correo_electronico);

            return $stmt->execute();
        } catch (PDOException $e) {
            // Puedes registrar el error si lo deseas
            echo "❌ Error al insertar proveedor: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerTodos(){
        $stmt = $this->db->query("SELECT id_proveedor, nombre FROM proveedores");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
