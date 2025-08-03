<?php
//incluye el modelo pedido que contiene la logica de base de datos
require_once __DIR__ . '/../Modelo/Pedido.php';

//define la clase del controlador de pedidos
class PedidoControlador {

    // metodo para mostrar el formulario de creacion de pedidos
    public function crear() {
        session_start(); // inicia sesion para acceder a los datos del usuario

        $pedido = new Pedido(); // crea una instancia del modelo pedido
        $productos = $pedido->obtenerProductosDisponibles(); // obtiene productos en stock

        // carga la vista para crear un pedido, pasandole los productos

        include "../App/Vista/Pedido/crear.php";
    }


    //metodo para guardar un nuevo pedido en la base de datos
    public function guardar() {
        session_start(); // asegura que la sesion este activa
        $id_usuario = $_SESSION['usuario']['id_usuario'] ?? null; // obtiene el id del usuario logueado

        // si no hay sesion valida, muestra mensaje y detiene la ejecucion
        if (!$id_usuario) {
            echo "No estás logueado.";
            return;
        }

        //recoge los productos enviados desde el formulario (clave = id_producto, valor = cantidad)

        $productos = $_POST['productos'] ?? [];

        $pedido = new Pedido(); // crea el modelo pedido
        $resultado = $pedido->crearPedido($id_usuario, $productos); // guarda el pedido en la base de datos

        //muestra un mensaje dependiendo si se guardo o no correctamente
        if ($resultado) {
            echo "<h3>✅ Pedido realizado correctamente.</h3>";
        } else {
            echo "<h3>❌ Error al crear pedido.</h3>";
        }
    }

    //metodo para que el administrador pueda ver la lista de pedidos
    public function listar() {
    session_start(); // inicia sesion

    // Verifica si hay un usuario logueado y si es administrador
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
        echo "⚠️ Acceso denegado.";
        return;
    }

    $pedido = new Pedido(); // instancia del modelo pedido
    $pedidos = $pedido->listarPedidos(); // obtiene la lista de pedidos


    //carga la vista para mostrar la tabla pedidos
    include __DIR__ .  "../../Vista/Pedido/listar.php";
}
}

?>