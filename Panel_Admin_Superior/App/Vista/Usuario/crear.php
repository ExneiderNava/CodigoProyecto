<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Usuario</title>
  <!-- ✅ Bootstrap importado desde CDN para estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="text-center mb-4">👤 Registrar nuevo usuario</h2>

  <!-- ✅ Sección de mensajes según variable $mensaje -->
  <?php if ($mensaje === 'exito'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      ✅ <strong>Usuario registrado correctamente.</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    <div class="d-flex justify-content-center gap-3 mb-4">
      <a href="/Proyecto_F2/Public/admin.php" class="btn btn-primary">← Volver al panel del administrador</a>
      <a href="/Proyecto_F2/Public/registro_usuario.php" class="btn btn-success">➕ Registrar otro usuario</a>
    </div>
  <?php elseif ($mensaje === 'error'): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      ❌ <strong>Error al registrar el usuario.</strong> Intenta nuevamente.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  <?php endif; ?>

  <!-- ✅ Formulario de registro -->
  <form action="" method="POST" class="bg-white p-4 shadow rounded">
    <div class="row mb-3">
      <div class="col">
        <input type="text" name="Nombres_usuario" class="form-control" placeholder="Nombres" required>
        <!-- ❌ Asegúrate que el campo en BD se llama exactamente 'Nombres_usuario' -->
      </div>
      <div class="col">
        <input type="text" name="Apellidos_usuario" class="form-control" placeholder="Apellidos" required>
        <!-- ❌ Verifica que 'Apellidos_usuario' coincida con la BD (mayúsculas incluidas) -->
      </div>
    </div>

    <div class="row mb-3">
      <div class="col">
        <input type="email" name="Correo_Electronico" class="form-control" placeholder="Correo electrónico" required>
        <!-- ✅ Campo tipo email para validación automática -->
      </div>
      <div class="col">
        <input type="text" name="Celular" class="form-control" placeholder="Celular" required>
        <!-- ❌ Confirmar que en la BD se llama exactamente 'Celular' -->
      </div>
    </div>

    <div class="row mb-3">
      <div class="col">
        <input type="number" name="edad" class="form-control" placeholder="Edad" required>
        <!-- ❌ En la base de datos este campo debe estar como 'Edad' (verifica la mayúscula inicial) -->
      </div>
      <div class="col">
        <select name="tipo_documento" class="form-select" required>
          <option value="">Tipo de documento</option>
          <option value="1">Cédula</option>
          <option value="2">Tarjeta de identidad</option>
        </select>
        <!-- ❌ Asegúrate de que 'tipo_documento' coincida exactamente con el nombre en la tabla -->
      </div>
      <div class="col">
        <input type="number" name="Id_usuario" class="form-control" placeholder="Número de documento" required>
        <!-- ❌ Revisa que este campo sea 'Id_usuario' con esa misma capitalización -->
      </div>
    </div>

    <div class="mb-3">
      <select name="Rol" class="form-select" required>
        <option value="">Seleccione rol</option>
        <option value="Estudiante">Estudiante</option>
        <option value="Profesor">Profesor</option>
        <option value="Empleado">Empleado</option>
        <option value="Administrador">Administrador</option>
      </select>
      <!-- ❌ Verifica que en la base de datos se guarde el rol con el mismo nombre y capitalización -->
    </div>

    <button type="submit" name="crear" class="btn btn-primary w-100">✅ Registrar</button>
    <!-- ✅ Botón para enviar formulario con atributo name 'crear' -->
  </form>
</div>

<!-- ✅ Bootstrap script para funcionalidad de alertas y componentes -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
