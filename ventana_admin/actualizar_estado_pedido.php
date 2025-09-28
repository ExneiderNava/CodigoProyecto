<?php

header('Content-Type: application/json');
include '../../conexion_bd/conexionBD.php';

if(isset($_POST['id_pedido']) && isset($_POST['estado'])){
    $id = intval($_POST['id_pedido']);
    $estado = $_POST['estado'];

    $stmt = $conexion->prepare("UPDATE ventas_pedidos SET ventas_pedidos.estado = ? WHERE ventas_pedidos.Id = ?");
    $stmt->bind_param("si", $estado, $id);

    if($stmt->execute()){

        if($estado === "cancelado"){
            $obtenerDetalles = "SELECT id_producto, cantidad FROM detalles_pedido WHERE id_pedido = $id";
            $resultadoDetalles = mysqli_query($conexion, $obtenerDetalles);

            while($fila = mysqli_fetch_assoc($resultadoDetalles)){
                $id_producto = $fila['id_producto'];
                $cantidad = $fila['cantidad'];

                $sumarStock = "UPDATE productos SET Cantidad_en_Stock = Cantidad_en_Stock + $cantidad WHERE Id_Producto = $id_producto";
                mysqli_query($conexion, $sumarStock);
            }
        }
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error actualizando el estado"]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}
?>