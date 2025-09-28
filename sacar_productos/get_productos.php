<?php

$conexion = new mysqli("localhost","root","My109065","proyecto_ebenezer");

if ($conexion->connect_error){
    die("conexion fallida: ". $conexion->connect_error);
}

$sql = "SELECT productos.Id_Producto, productos.Nombre_Producto,
productos.Precio_venta, productos.Foto, productos.Cantidad_en_Stock, productos.Tipo_Producto
FROM productos;";
$resultado = $conexion->query($sql);

$productos = array();

while($fila = $resultado->fetch_assoc()){
    $fila['Foto'] = base64_encode($fila['Foto']);
    $productos[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($productos);

$conexion->close();


?>
