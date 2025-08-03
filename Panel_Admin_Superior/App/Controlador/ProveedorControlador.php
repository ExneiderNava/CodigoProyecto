<?php
require_once __DIR__ . '/../Modelo/ProveedorModelo.php';

class ProveedorControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new ProveedorModelo();
    }

    public function guardar() {
        // Validar campos esperados desde el formulario
        if (
            isset($_POST['nombre']) &&
            isset($_POST['celular']) &&
            isset($_POST['correo_electronico'])
        ) {
            // Sanitizar entradas básicas
            $nombre = trim($_POST['nombre']);
            $celular = trim($_POST['celular']);
            $correo = trim($_POST['correo_electronico']);

            // Puedes agregar más validaciones aquí si deseas (formato, largo, etc)

            return $this->modelo->insertarProveedor($nombre, $celular, $correo);
        }

        return false;
    }
}
