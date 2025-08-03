<?php
require_once '../App/Controlador/PedidoControlador.php'; // ✅ Se incluye correctamente el controlador del pedido

$controlador = new PedidoControlador(); // ✅ Se crea una instancia del controlador

$controlador->listar(); // ✅ Se llama al método 'listar' del controlador, que probablemente carga una vista o lista de pedidos
