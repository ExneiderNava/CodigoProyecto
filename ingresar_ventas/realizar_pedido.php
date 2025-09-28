<?php
include __DIR__ . '/../../conexion_bd/conexionBD.php';

$metodo = $_POST['metodo_pago'];
$carrito = json_decode($_POST['carrito'], true);
$id_usuario = $_POST['id_usuario'];

error_log("DEBUG ID USUARIO: " . var_export($id_usuario, true));
error_log("DEBUG POST: " . var_export($_POST, true));


date_default_timezone_set("America/Bogota");
$fecha = date("Y-m-d H:i:s");

$total = 0;

foreach($carrito as $item){
    $total += $item['precio'] * $item['cantidad'];
}

$sql = "INSERT INTO ventas_pedidos (ventas_pedidos.estado, ventas_pedidos.Id_Administrador, ventas_pedidos.id_usuario, ventas_pedidos.Fecha_Venta, ventas_pedidos.medio_pago, ventas_pedidos.total)
VALUES ('pendiente', 1090527809, '$id_usuario' , '$fecha','$metodo','$total');";
$result = mysqli_query($conexion, $sql);

if($result){
    $id_pedido = mysqli_insert_id($conexion);

    foreach($carrito as $item){
        $id_producto = $item['id'];
        $nombre = mysqli_real_escape_string($conexion, $item['nombre']);
        $precio = $item['precio'];
        $cantidad = $item['cantidad'];
        $subtotal = $precio * $cantidad;

        $sqlDetalle = "INSERT INTO detalles_pedido (detalles_pedido.id_pedido, detalles_pedido.id_producto, detalles_pedido.nombre_producto, detalles_pedido.precio_und, detalles_pedido.cantidad, detalles_pedido.sum_total)
        VALUES ($id_pedido, $id_producto, '$nombre', $precio, $cantidad, $subtotal);";

        $resDetalle = mysqli_query($conexion, $sqlDetalle);

        if(!$resDetalle){
            echo json_encode([
                "success" => false,
                "error" => mysqli_error($conexion),
                "sql" => $sqlDetalle
            ]);
            exit;
        }
    

    $SQLactualizarStock = "UPDATE productos 
                            SET Cantidad_en_Stock = Cantidad_en_Stock - $cantidad 
                            WHERE Id_Producto = $id_producto AND Cantidad_en_Stock >= $cantidad";
    $actualizarStock = mysqli_query($conexion, $SQLactualizarStock);

    if(!$actualizarStock || mysqli_affected_rows($conexion) == 0){
        echo json_encode([
            "success" => false,
            "error" => "Error al actualizar el stock, no hay mas cantidad",
            "sql" => $SQLactualizarStock
        ]);
        exit;
    }
}

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => mysqli_error($conexion)]);
}


?>