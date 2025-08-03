<?php
// incluye la clase que conecta a la base de datos
require_once __DIR__ . '/../Centro/DataBase.php';

class Usuario {
    //propiedad que almacena la conexion a la base de datos
    private $db;

    // constructor: se ejecuta al crear una instancia de esta clase
    public function __construct() {
        // se crea una nueva conexion a la base de datos usando la clase DataBase
        $this->db = (new DataBase())->conn;
    }

    /**
     * Método para obtener todos los usuarios registrados
     * @return array - Lista de usuarios en forma de arreglo asociativo
     */

    public function listarUsuarios() {
        $sql = "SELECT * FROM usuarios"; // consulta SQL para traer todos los usuarios
        $stmt = $this->db->query($sql); // ejecuta la consulta directamente
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // retorna todos los resultados como array asociativo
    }


     /**
     * Método para registrar un nuevo usuario
     * @param array $datos - Datos recibidos del formulario ($_POST)
     * @return bool - true si se insertó correctamente, false si falló
     */

public function registrar($datos) {
    // consulta SQL
    $sql = "INSERT INTO usuarios (
                usuarios.Id_usuario,
                usuarios.tipo_documento,
                usuarios.Nombres_usuario,
                usuarios.Apellidos_usuario,
                usuarios.Rol,
                usuarios.edad,
                usuarios.Celular,
                usuarios.Correo_Electronico,
                usuarios.cod_acceso) 
                VALUES (:id, :doc, :nombres, :apellidos, :rol, :edad, :celular, :correo, :codigo);";
    // prepara la consulta            
    $stmt = $this->db->prepare($sql);


    // ejecuta la consulta con los valores recibidos del formulario
    return $stmt->execute([
        ':id' => $datos['documento'],
        ':doc' => $datos['tipo_documento'],
        ':nombres' => $datos['Nombres_usuario'],
        ':apellidos' => $datos['Apellidos_usuario'],
        ':rol' => $datos['rol'],
        ':edad' => $datos['edad'],
        ':celular' => $datos['Celular'],
        ':correo' => $datos['Correo_Electronico'],
        ':codigo' => $datos['cod_acceso']
    ]);

    // se muestrar los resultados

    if ($resultado) {
        echo "✅ Usuario creado correctamente.";
        return true;
    } else {
        echo "❌ Error al registrar usuario:<br>";
        print_r($stmt->errorInfo());  // ⛔ Esto mostrará el error real de MySQL
        return false;
}
}

 //en esta funcion se obtienen los usuarios por id

 public function obtenerPorId($id_usuario) {
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_STR);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);


    return $resultado;
}


    // esta funcion se hizo para actualizar los datos del usuario si se requiere
    public function actualizar($datos) {
    $sql = "UPDATE usuarios SET
                tipo_documento = :doc,
                Nombres_usuario = :nombres,
                Apellidos_usuario = :apellidos,
                Rol = :rol,
                Edad = :edad,
                Celular = :celular,
                Correo_Electronico = :correo,
                cod_acceso = :codigo
            WHERE id_usuario = :id";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':doc' => $datos['tipo_documento'],
        ':nombres' => $datos['Nombres_usuario'],
        ':apellidos' => $datos['Apellidos_usuario'],
        ':rol' => $datos['Rol'],
        ':edad' => $datos['Edad'],
        ':celular' => $datos['Celular'],
        ':correo' => $datos['Correo_Electronico'],
        ':codigo' => $datos['cod_acceso'],
        ':id' => $datos['Id_usuario']
    ]);
}


// esta funcion permite eliminar el usuario que aun no tengo pedidos generados
public function eliminar($id_usuario) {
    try {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "❌ No se puede eliminar el usuario porque tiene registros relacionados.";
        return false;
    }
}







}

?>