<?php
header('Content-Type: application/json');
error_reporting(0);

include '../../conexion_bd/conexionBD.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $input = json_decode(file_get_contents("php://input"), true);

    if(isset($input['codigo'])) {
        $codigo = $input['codigo'];

        $stmt = $conexion->prepare("SELECT * FROM usuarios where cod_acceso = ? LIMIT 1");
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            echo json_encode(["success" => "exito", "mensaje" => "acceso permitido", "rol" => $fila["Rol"], "id_usuario" => $fila["id_usuario"]]);
        } else {
            echo json_encode(["success" => false, "mensaje" => "codigo incorrecto"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "mensaje" => "codigo no recibido"]);
    }

} else {
    echo json_encode(["success" => false, "mensaje" => "Método no permitido"]);
}


?>