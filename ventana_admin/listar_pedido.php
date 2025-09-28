<?php

header('Content-Type: application/json');
include '../../conexion_bd/conexionBD.php';

$stmt = $conexion->prepare("SELECT ventas_pedidos.Id AS Id_Pedido, usuarios.Nombres_usuario AS Nombre_Cliente
    FROM ventas_pedidos
    INNER JOIN usuarios ON ventas_pedidos.id_usuario = usuarios.Id_usuario
    WHERE ventas_pedidos.estado = 'pendiente'
    ORDER BY ventas_pedidos.Fecha_Venta ASC");
$stmt->execute();
$result = $stmt->get_result();

$pedidos = [];
while($fila = $result->fetch_assoc()){
    $pedidos[] = $fila;
}


echo json_encode($pedidos);

?>