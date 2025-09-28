<?php

header('Content-Type: application/json');
include '../../conexion_bd/conexionBD.php';

if (isset($_GET['id_pedido'])){
    $id = intval($_GET['id_pedido']);

    $stmt = $conexion->prepare("SELECT usuarios.Nombres_usuario, ventas_pedidos.total
        FROM ventas_pedidos
        INNER JOIN usuarios ON ventas_pedidos.id_usuario = usuarios.Id_usuario
        WHERE ventas_pedidos.Id = ?");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $pedido = $stmt->get_result()->fetch_assoc();

        $stmt2 = $conexion->prepare("SELECT productos.Nombre_Producto AS producto, detalles_pedido.cantidad, detalles_pedido.precio_und AS precio
        FROM detalles_pedido
        INNER JOIN productos ON detalles_pedido.id_producto = productos.Id_Producto
        WHERE detalles_pedido.id_pedido = ?");

        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        $productos = [];
        while($fila = $result2->fetch_assoc()){
            $productos[] = $fila;
        }

        if($pedido){

        echo json_encode([
            "Nombre_Cliente" => $pedido["Nombres_usuario"],
            "Total" => $pedido["total"],
            "productos" => $productos
        ]);
        } else {
        echo json_encode(["error" => "pedido no encontrado"]);
        }

} else {
    echo json_encode(["error" => "Falta id_pedido"]);
}

?>