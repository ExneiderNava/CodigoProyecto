<?php
//importa el modelo producto, que maneja las operaciones con la base de datos
require_once __DIR__ . '/../Modelo/Producto.php';

//define la clase controlador para gestionar productos
class ProductoControlador {


    //metodo para guardar un producto en la base de datos
    public function guardar() {
        $producto = new Producto(); // crea una instancia del modelo producto
        return $producto->registrar($_POST);  // intenta registar los datos recibidos del formulario
                                                        // retorna true si se guarda correctamente, o false si falla
    }

    //metodo para obetener todos los productos registrador
    public function listar() {
        $producto = new Producto(); // crea la instancia modelo producto
        return $producto->obtenerTodos();  // retorna todos los productos como array
    }

    //metodo principal que gestiona la logica de creacion y visualizacion
    public function crear() {
        $mensaje = ''; // mensaje para mostrar al usuario (exito o error)
        $productos = []; // arreglo para almacenar producto (si se listan)

        // Si el formulario fue enviado con el boton registrar
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
            $resultado = $this->guardar(); // intenta guardar el producto
            $mensaje = $resultado ? 'exito' : 'error'; // asigna el mensaje dependiendo del resultado
        }


        //este verificaion es para agregarle nuevas unidades al producto
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_unidades'])) {
            $producto = new Producto();
            $resultado = $producto->agregarUnidades($_POST);  // Llama al modelo
            $mensaje = $resultado ? 'unidades_agregadas' : 'error_agregar_unidades';
        }

        // Si se solicitó ver la lista (por GET)
        if (isset($_GET['listar'])) {
            $productos = $this->listar(); // llama al metodo listar() para obtener todos los productos
        }


        //se dirige al modelo del proveedor para sacar la lista de los proveedores disponibles
        require_once __DIR__ . '/../Modelo/ProveedorModelo.php';
        // inicializa el objeto proveedor
        $proveedor = new ProveedorModelo();
        //llama al metodo obtener todos, que saca los proveedores existentes en la base de datos
        $proveedores = $proveedor->obtenerTodos();

        // finalmente se carga la vista que se encarga del diseño
        include __DIR__. '../../Vista/Producto/crear.php'; //aqui se mostrara el formulario y mensajes
    }

    public function editar() {
    // Validar existencia de los campos requeridos
    if (
        isset($_POST['Id_Producto']) &&
        isset($_POST['Nombre_Producto']) &&
        isset($_POST['Precio_venta']) &&
        isset($_POST['Precio_costo']) &&
        isset($_POST['Cantidad_en_Stock']) &&
        isset($_POST['Tipo_Producto'])
    ) {
        // Recoge los datos del formulario
        $datos = [
            'Id_Producto' => $_POST['Id_Producto'],
            'Nombre_Producto' => $_POST['Nombre_Producto'],
            'Precio_venta' => $_POST['Precio_venta'],
            'Precio_costo' => $_POST['Precio_costo'],
            'Cantidad_en_Stock' => $_POST['Cantidad_en_Stock'],
            'Tipo_Producto' => $_POST['Tipo_Producto']
        ];

        // Llama al modelo
        $producto = new Producto();
        $resultado = $producto->editar($datos); // este método ya está implementado en el modelo

        // Puedes usar redirección o una variable de sesión si quieres mostrar mensaje
        if ($resultado) {
            echo "<script>alert('✅ El producto fue editado'); window.location.href='producto.php?listar';</script>";
        } else {
            echo "<script>alert('❌ Error al editar el producto'); window.location.href='producto.php?listar';</script>";
        }
    }
}


}




?>