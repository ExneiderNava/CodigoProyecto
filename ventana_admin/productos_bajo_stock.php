<?php
header('Content-Type: application/json');
include '../../conexion_bd/conexionBD.php';

$query = "SELECT Nombre_Producto, Cantidad_en_Stock FROM productos WHERE Cantidad_en_Stock <= 3";
$resultado = mysqli_query($conexion, $query);

$productos = [];

while($fila = mysqli_fetch_assoc($resultado)){
    $productos[] = $fila;
}

echo json_encode($productos);


?>