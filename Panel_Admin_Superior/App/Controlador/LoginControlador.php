<?php
//requere la clase base controlador (ubicada en /Centro)
require_once __DIR__ . '/../Centro/Controlador.php';
//requiere el modelo login. que contiene la logica para validar usuarios
require_once __DIR__ . '/../Modelo/Login.php';

// clase LoginControlador que extiende de la clase Controlador base
class LoginControlador extends Controlador {

    //metodo principal para autenticar al usuario
    public function autenticar() {

        //inicia la sesion solo si aun no ha sido iniciada
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

        //obtiene el correo y celular desde el formulario enviado por POST
        // si no existen, los inicializa como cadenas vacias    
        $correo = $_POST['correo'] ?? '';
        $celular = $_POST['celular'] ?? '';

        //crea una instancia del modelo login

        $login = new Login();

        //valida el usuario con los datos proporcionados
        $usuario = $login->validarUsuario($correo, $celular);

        //si se encontro un usuario valido
        if ($usuario) {
            //guarda los datos del usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            

            // Redirigir según rol
            switch ($usuario['Rol']) {
                case 'Estudiante':
                case 'Profesor':
                    // estudiantes y profesores van a la vista usuario
                    header('Location: /proyecto_F2/Panel_Admin_Superior/Public/usuario.php');
                    break;
                case 'Empleado':
                    //empleados van a la vista interna de pedidos
                    header('Location: ../App/Vista/Pedido/index.php');
                    break;
                case 'Administrador':
                    // administradores van al panel de administrador
                    header('Location: /Proyecto_F2/Panel_Admin_Superior/Public/admin.php');
                    break;
            }
        } else {
            // si no se encuentra el usuario, muestra mensaje de error
            echo "Usuario no válido.";
        }

        

        //pruebas

        echo "<hr><b>DEBUG:</b><br>";

echo "<pre>";
echo "POST:\n";
print_r($_POST);

echo "\nCorreo recibido: " . ($_POST['Correo_Electronico'] ?? 'NULO');
echo "\nCelular recibido: " . ($_POST['Celular'] ?? 'NULO');

echo "\n\nResultado de validarUsuario:\n";
var_dump($usuario);
echo "</pre>";

       
    }
}
