<?php
// importa el archivo de configuracion (donde esta DB_HOST, DB_NAME, etc...)
require_once __DIR__ . '/../../../config.php';

//clase encargada de gestionar la conexion a la base de datos
class DataBase {

    //atributo publico que almacenara la conexion PDO
    public $conn;
    // constructor de la clase, se ejecuta automaticamente al crear un objeto DataBase
    public function __construct() {
        try {
            //Intenta crear una nueva conexion PDO usando las constantes definidas en config.php
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, // direcion del servidor y nombre de la base de datos
                DB_USER, // usuario de la base de datos
                DB_PASS // contraseña del usuario

                
            );
            //configura PDO para que lance exepciones si ocurre un error (util para detectar fallos)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // si ocurre un error en la conexion, muestra el mensaje y detiene el script
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
