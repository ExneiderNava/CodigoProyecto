<?php
// Incluir el controlador de usuario
require_once '../App/Controlador/UsuarioControlador.php';
$controlador = new UsuarioControlador();

$mensaje = '';

// Validar si se envió el formulario para crear un usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $resultado = $controlador->guardar(); // Llama al método guardar del controlador
    $mensaje = $resultado ? 'exito' : 'error'; // Establece el mensaje según resultado
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Usuario</title>
  <!-- Carga de estilos de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="text-center mb-4">👤 Registrar nuevo usuario</h2>

  <!-- Mensajes de éxito o error -->
  <?php if ($mensaje === 'exito'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      ✅ <strong>Usuario registrado correctamente.</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    <div class="d-flex justify-content-center gap-3 mb-4">
      <a href="/Proyecto_F2/Panel_Admin_Superior/Public/admin.php" class="btn btn-primary">← Volver al panel del administrador</a>
      <a href="/Proyecto_F2/Panel_Admin_Superior/Public/registro_usuario.php" class="btn btn-success">➕ Registrar otro usuario</a>
    </div>
  <?php elseif ($mensaje === 'error'): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      ❌ <strong>Error al registrar el usuario.</strong> Intenta nuevamente.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  <?php endif; ?>

  <!-- Formulario de registro de usuario -->
  <form action="" method="POST" class="bg-white p-4 shadow rounded">
    <!-- Campo: Nombres y Apellidos -->
    <div class="row mb-3">
      <div class="col">
        <input type="text" name="Nombres_usuario" class="form-control" placeholder="Nombres" required>
      </div>
      <div class="col">
        <input type="text" name="Apellidos_usuario" class="form-control" placeholder="Apellidos" required>
      </div>
    </div>

    <!-- Campo: Correo y Celular -->
    <div class="row mb-3">
      <div class="col">
        <input type="email" name="Correo_Electronico" class="form-control" placeholder="Correo electrónico" required>
      </div>
      <div class="col">
        <input type="text" name="Celular" class="form-control" placeholder="Celular" required>
      </div>
    </div>

    <!-- Campo: Edad, Tipo de documento, Número de documento -->
    <div class="row mb-3">
      <div class="col">
        <input type="number" name="edad" class="form-control" placeholder="Edad" required>
      </div>
      <div class="col">
        <select name="tipo_documento" class="form-select" required>
          <option value="">Tipo de documento</option>
          <option value="1">Cédula</option>
          <option value="2">Tarjeta de identidad</option>
        </select>
      </div>
      <div class="col">
        <input type="number" name="documento" class="form-control" placeholder="Número de documento" required>
      </div>
    </div>

    <!-- Campo: Rol y Código de acceso -->
    <div class="row mb-3">
      <div class="col">
        <select name="rol" class="form-select" required>
          <option value="">Seleccione rol</option>
          <option value="Estudiante">Estudiante</option>
          <option value="Profesor">Profesor</option>
          <option value="Empleado">Empleado</option>
          <option value="Administrador">Administrador</option>
        </select>
      </div>
      <div class="col">
        <input type="password" name="cod_acceso" class="form-control" placeholder="Código de acceso" inputmode="numeric" pattern="[0-9]*" required>
      </div>
    </div>

    <!-- Botón para enviar el formulario -->
    <button type="submit" name="crear" class="btn btn-primary w-100">✅ Registrar</button>
  </form>
</div>

<!-- Botones para ver usuarios o volver -->
<div class="d-flex justify-content-center gap-3 mt-4">
  <a href="ver_usuarios.php" class="btn btn-info">👥 Ver usuarios registrados</a>
  <a href="admin.php" class="btn btn-secondary">← Volver al panel del administrador</a>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <!-- Formulario de edición de usuario -->
      <form id="formEditarUsuario" method="POST" action="../Controlador/UsuarioControlador.php">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarUsuarioLabel">✏️ Editar usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <!-- Campo oculto para ID del usuario -->
          <input type="hidden" name="id_usuario" id="editar_id_usuario">

          <!-- Campos: Nombres y Apellidos -->
          <div class="row mb-3">
            <div class="col">
              <input type="text" name="Nombres_usuario" id="editar_nombres" class="form-control" placeholder="Nombres" required>
            </div>
            <div class="col">
              <input type="text" name="Apellidos_usuario" id="editar_apellidos" class="form-control" placeholder="Apellidos" required>
            </div>
          </div>

          <!-- Campos: Correo y Celular -->
          <div class="row mb-3">
            <div class="col">
              <input type="email" name="Correo_Electronico" id="editar_correo" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="col">
              <input type="text" name="Celular" id="editar_celular" class="form-control" placeholder="Celular" required>
            </div>
          </div>

          <!-- Campos: Edad, Tipo y número de documento -->
          <div class="row mb-3">
            <div class="col">
              <input type="number" name="edad" id="editar_edad" class="form-control" placeholder="Edad" required>
            </div>
            <div class="col">
              <select name="tipo_documento" id="editar_tipo_documento" class="form-select" required>
                <option value="">Tipo de documento</option>
                <option value="1">Cédula</option>
                <option value="2">Tarjeta de identidad</option>
              </select>
            </div>
            <div class="col">
              <input type="number" name="documento" id="editar_documento" class="form-control" placeholder="Número de documento" required>
            </div>
          </div>

          <!-- Campos: Rol y Código de acceso -->
          <div class="row mb-3">
            <div class="col">
              <select name="rol" id="editar_rol" class="form-select" required>
                <option value="">Seleccione rol</option>
                <option value="Estudiante">Estudiante</option>
                <option value="Profesor">Profesor</option>
                <option value="Empleado">Empleado</option>
                <option value="Administrador">Administrador</option>
              </select>
            </div>
            <div class="col">
              <input type="password" name="cod_acceso" id="editar_codigo" class="form-control" placeholder="Código de acceso" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <!-- Botones del modal -->
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" name="editar" class="btn btn-success">💾 Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

