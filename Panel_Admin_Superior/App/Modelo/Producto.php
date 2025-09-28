<?php

//incluye la clase que gestiona la conexion a la base de datos
require_once __DIR__ . '/../Centro/DataBase.php';

class Producto {

    //propiedad para la conexion a la base de datos
    private $db;


    //contructor: se ejecuta automaticamente al instanciar la clase
    // establece la conexion con la base de datos
    public function __construct() {
        $this->db = (new DataBase())->conn;
    }

    /**
     * Registra un nuevo producto en la base de datos.
     * @param array $datos - Datos del producto (vienen del formulario POST).
     * @return bool - true si se guardó correctamente, false si hubo error.
     */

    public function registrar($datos) {

        //obtiene el contenido binario de la imagen cargada desde el formulario
         $foto = isset($_FILES['foto']) && is_uploaded_file($_FILES['foto']['tmp_name']) 
    ? file_get_contents($_FILES['foto']['tmp_name']) 
    : null;

        // consulta SQL para insertar un nuevo producto en la tabla productos
        $sql = "INSERT INTO productos (productos.Id_Producto, productos.Nombre_Producto, productos.Precio_venta, productos.Precio_costo, productos.Cantidad_en_Stock, productos.Tipo_Producto, productos.Foto)
                VALUES (:id, :nombre, :venta, :costo, :cantidad, :tipo, :foto)";
        //prepara la consulta para prevenir inyeccion SQL        
        $stmt = $this->db->prepare($sql);

        //ejecuta la consulta con los datos del formulario
        $resultado = $stmt->execute([
            ':id'=> $datos['Id_Producto'],
            ':nombre' => $datos['Nombre_Producto'],
            ':venta' => $datos['Precio_venta'],
            ':costo'=>$datos['Precio_costo'],
            ':cantidad' => $datos['Cantidad_en_Stock'],
            ':tipo' => $datos['Tipo_Producto'],
            ':foto' => $foto
        ]);

        if (!$resultado) return false;

        // en esta parte le añade a que proveedor pertenece el producto con una barra que trae los datos del proveedor en tiempo real

        if (!empty($datos['Id_Proveedor'])) {
            $sql2 = "INSERT INTO producto_proveedor (id_producto, id_proveedor, precio, cantidad_adquirida) 
                     VALUES (:id_producto, :id_proveedor, :precio_unidad, :cantidad_adquirida)";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([
                ':id_producto'  => $datos['Id_Producto'],
                ':id_proveedor' => $datos['Id_Proveedor'],
                ':precio_unidad' => $datos['Precio_costo'],
                ':cantidad_adquirida' => $datos['Cantidad_en_Stock']
            ]);
        }

        return true;
    }

    /**
     * Obtiene todos los productos disponibles en stock.
     * Devuelve solo productos cuya cantidad en stock sea mayor a 0.
     * @return array - Lista de productos disponibles.
     */

    public function obtenerTodos() {
    // ejecuta una consulta SQL para traer todos los productos con stock disponible
    $stmt = $this->db->query("SELECT * FROM productos WHERE productos.Cantidad_en_Stock > 0");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

            
    }


    //esta funcion se hizo para el boton agregar unidades, para insertar más de cada producto en caso necesario
    public function agregarUnidades($datos) {
    // Aumentar stock en la tabla productos
    $sql = "UPDATE productos 
            SET Cantidad_en_Stock = Cantidad_en_Stock + :cantidad
            WHERE Id_Producto = :id_producto";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':cantidad' => $datos['cantidad'],
        ':id_producto' => $datos['id_producto']
    ]);

    return true;
}


// se invluye esta funcion para guardar los cambios del producto editado
public function editar($datos) {
    $sql = "UPDATE productos 
            SET Nombre_Producto = :nombre,
                Precio_venta = :venta,
                Precio_costo = :costo,
                Cantidad_en_Stock = :cantidad,
                Tipo_Producto = :tipo
            WHERE Id_Producto = :id";

    $stmt = $this->db->prepare($sql);

    $params = [
        ':id' => $datos['Id_Producto'],
        ':nombre' => $datos['Nombre_Producto'],
        ':venta' => $datos['Precio_venta'],
        ':costo' => $datos['Precio_costo'],
        ':cantidad' => $datos['Cantidad_en_Stock'],
        ':tipo' => $datos['Tipo_Producto']
    ];

    return $stmt->execute($params);
}

}

?>
