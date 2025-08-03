<?php
//carga el controlador base, que tiene metodos reutilizables como 'vista'
require_once __DIR__ . '/../Centro/Controlador.php';

//carga el modelo usuario, que se encarga de la logica con la base de datos
require_once __DIR__ . '/../Modelo/Usuario.php';

//define la clase UsuarioControlador que hereda de Controlador
class UsuarioControlador extends Controlador {

    // metodo por defecto, simplemente muestra un mensaje basico
    public function index(): void {
        echo "Bienvenido al módulo de Usuarios";
    }

    // metodo para listar todos los usuarios registrados
public function listar(): array {
    $usuario = new Usuario(); // crea ua instancia del modelo
    return $usuario->listarUsuarios(); // obtiene todos los usuarios
}

//muestra la vista para registrar un nuevo usuario
public function crear() {
    $this->vista('Usuario/crear'); // carga la vista usuario/crear.php
}

// guarda el nuevo usuario en la base de datos
public function guardar() {


    //esto es una validación que asegura que el codigo ingresado solo tenga numeros
    if (!isset($_POST['cod_acceso']) || !preg_match('/^\d+$/', $_POST['cod_acceso'])) {
        return false;
    }

    $usuario = new Usuario(); // instancia el modelo
    $resultado = $usuario->registrar($_POST); // intenta registrar los datos del formulario

    // esta linea es la que devuelve true o false al archivo que llama al controlador

    return $resultado ? true : false;



    //muestra un mensaje si el usuario fue registrado correctamente o no
    if ($resultado) {
        echo "<h3 style='color:green'>✅ Usuario registrado correctamente</h3>";
        echo "<a href='/Proyecto_F2/Public/usuario.php'>Volver al formulario</a><br>";
        echo "<a href='/Proyecto_F2/Public/admin.php'>Volver al panel del Administrador</a>";
    } else {
        echo "<h3 style='color:red'>❌ Error al registrar usuario</h3>";
        echo "<a href='/Proyecto_F2/Public/usuario.php'>Volver al formulario</a><br>";
        echo "<a href='/Proyecto_F2/Public/admin.php'>Volver al panel del Administrador</a>";
    }
}


// con esta funcion se edita el usuario que ya esta registrado
public function editar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['accion']) && $_GET['accion'] === 'actualizar') {
            // ✅ Procesar actualización
            $usuarioModel = new Usuario();

            $datos = [
                'id_usuario' => $_POST['Id_usuario'],
                'tipo_documento' => $_POST['tipo_documento'],
                'cod_acceso' => $_POST['cod_acceso'],
                'Nombres_usuario' => $_POST['Nombres_usuario'],
                'Apellidos_usuario' => $_POST['Apellidos_usuario'],
                'Rol' => $_POST['Rol'],
                'Edad' => $_POST['Edad'],
                'Celular' => $_POST['Celular'],
                'Correo_Electronico' => $_POST['Correo_Electronico']
            ];

            $exito = $usuarioModel->actualizar($datos);

            if ($exito) {
                header('Location: usuario.php?accion=ver_usuarios&mensaje=actualizado');
                exit;
            } else {
                echo "❌ Error al actualizar el usuario en la base de datos.";
            }

        } elseif (isset($_GET['id'])) {
            // ✅ Mostrar formulario con datos actuales
            $id = $_GET['id'];
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->obtenerPorId($id);  // ✅ obtiene el array con los datos

            if ($usuario) {
                include '../App/Vista/Usuario/editar.php';
            } else {
                echo "❌ Usuario no encontrado.";
            }
        } else {
            echo "❌ ID no proporcionado.";
        }
    }



   // y con esta funcion se actualizan los datos del usuario, con los datos que fueron modificados
    public function actualizar() {
    if (!isset($_POST['Id_usuario'])) {
        echo "❌ ID de usuario no proporcionado para la actualización.";
        return;
    }

    $usuario = new Usuario();
    $resultado = $usuario->actualizar($_POST);

    if ($resultado) {
        echo "<h3 style='color:green'>✅ Usuario actualizado correctamente</h3>";
        echo "<a href='/Proyecto_F2/Panel_Admin_Superior/Public/ver_usuarios.php'>Volver a la lista de usuarios</a>";
    } else {
        echo "<h3 style='color:red'>❌ Error al actualizar usuario</h3>";
        echo "<a href='/Proyecto_F2/Panel_Admin_Superior/Public/usuario.php?accion=ver_usuarios'>Volver</a>";
    }


}


// esta es una funcion para eliminar usuarios, desde el boton eliminar
public function eliminar($id) {
    $usuario = new Usuario();
    return $usuario->eliminar($id);
}



}







?>