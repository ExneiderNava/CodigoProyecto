<?php

//incluye la clase que manela la conexion a la base de datos
require_once __DIR__ . '/../Centro/DataBase.php';

class Pedido {

    //propiedad para almacenar la conexion PDO
    private $db;

    // contructor: al crear el objeto, se conexta automaticamente a la base de datos
    public function __construct() {
        $this->db = (new DataBase())->conn;
    }

    
    /**
     * Crea un nuevo pedido con los productos seleccionados por el usuario.
     * @param int $id_usuario - ID del usuario que realiza el pedido.
     * @param array $productos - Lista de productos con sus cantidades.
     * @return bool - True si todo salió bien, False si hubo error.
     */

    public function crearPedido($id_usuario, $productos) {
        //inicia una transaccion (para asegurar que todas las operaciones se completen)
        $this->db->beginTransaction();

        try {
            // Inserta el pedido en la tabla ventas_pedidos
            $stmt = $this->db->prepare("INSERT INTO ventas_pedidos (ventas_pedidos.id_usuario, ventas_pedidos.Fecha_Venta, ventas_pedidos.estado) VALUES (?, NOW(), 'pendiente')");
            $stmt->execute([$id_usuario]);

            // recupera el id del nuevo pedido insertado
            $id_pedido = $this->db->lastInsertId();
            $total=0;

            // Recorre cada producto seleccionado por el usuario
            foreach ($productos as $id_producto => $cantidad) {
                // consulta el precio del producto
                 $stmt_precio = $this->db->prepare("SELECT productos.Precio_venta FROM productos WHERE productos.Id_Producto = ?");
            $stmt_precio->execute([$id_producto]);
            $producto = $stmt_precio->fetch(PDO::FETCH_ASSOC);


                // calcula el subtotal por producto
            $precio = $producto['Precio_venta'];
            $subtotal = $precio * $cantidad;
            $total += $subtotal;

            // Insertar el detalle del producto en la tabla detalles_pedido
            $stmt_detalle = $this->db->prepare("INSERT INTO detalles_pedido (detalles_pedido.id_pedido, detalles_pedido.id_producto, detalles_pedido.cantidad) VALUES (?, ?, ?)");
            $stmt_detalle->execute([$id_pedido, $id_producto, $cantidad]);

            // Opcional: actualiza el stock del producto restando la cantidad comprada
            $stmt_stock = $this->db->prepare("UPDATE productos SET productos.Cantidad_en_Stock = productos.Cantidad_en_Stock - ? WHERE productos.Id_Producto = ?");
            $stmt_stock->execute([$cantidad, $id_producto]);
        }

        // despues de insertar todos los productos, actualiza el total del pedido
        $stmt_total = $this->db->prepare("UPDATE ventas_pedidos SET ventas_pedidos.total = ? WHERE ventas_pedidos.Id = ?");
        $stmt_total->execute([$total, $id_pedido]);

        //confirma todos los cambios en la base de datos
        $this->db->commit();
        return true;
    } catch (Exception $e) {
        //si hubo algun error, se cancelan todos los cambios
        $this->db->rollBack();
        echo "Error: " . $e->getMessage();
        return false;
    }

        }


    
    /**
     * Devuelve todos los productos disponibles con stock mayor a 0.
     * Se usa para mostrar el catálogo en el formulario de pedido.
     */


    public function obtenerProductosDisponibles() {
        $stmt = $this->db->query("SELECT * FROM productos WHERE productos.Cantidad_en_Stock > 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve una lista de todos los pedidos registrados, con datos del usuario.
     * Se usa para mostrar los pedidos en el panel del administrador.
     */

   public function listarPedidos() {
    $stmt = $this->db->query("
        SELECT 
            ventas_pedidos.Id AS id,
            usuarios.Nombres_usuario AS nombre,
            ventas_pedidos.id_usuario,
            ventas_pedidos.Fecha_Venta AS fecha,
            ventas_pedidos.estado,
            ventas_pedidos.total
        FROM ventas_pedidos
        JOIN usuarios ON ventas_pedidos.id_usuario = usuarios.Id_usuario
        ORDER BY ventas_pedidos.Id DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}

?>