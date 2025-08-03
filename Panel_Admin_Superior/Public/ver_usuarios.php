<?php
// Se incluye el archivo del controlador de usuarios
require_once '../App/Controlador/UsuarioControlador.php';

// Se crea una instancia del controlador
$controlador = new UsuarioControlador();

// Se obtienen los usuarios mediante el método listar()
$usuarios = $controlador->listar();

// Función auxiliar para traducir el ID del tipo de documento a un nombre legible
function obtenerNombreTipoDocumento($idTipo) {
  return match($idTipo) {
    1 => 'Cédula (CC)',
    2 => 'Tarjeta Identidad (TI)',
    3 => 'Permiso Protección Temporal (PPT)',
    4 => 'Cédula Extranjera (CE)',
    default => 'Desconocido'
  };
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Usuarios Registrados</title>

  <!-- Enlace a Bootstrap para estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Estilo para el campo de búsqueda */
    #buscador {
      max-width: 400px;
      margin: 0 auto 20px auto;
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="text-center mb-4">👥 Usuarios registrados</h2>

  <?php if (count($usuarios) === 0): ?>
    <!-- Mensaje si no hay usuarios registrados -->
    <div class="alert alert-warning text-center">
      ⚠️ No hay usuarios registrados en el sistema.
    </div>
  <?php else: ?>

    <!-- Campo de búsqueda -->
    <div id="buscador" class="mb-3">
      <input type="text" id="buscarInput" class="form-control" placeholder="🔎 Buscar usuario...">
    </div>

    <!-- Tabla de usuarios -->
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover" id="tablaUsuarios">
        <thead class="table-dark text-center">
          <tr>
            <th>ID</th>
            <th>Nombre completo</th>
            <th>Correo</th>
            <th>Celular</th>
            <th>Edad</th>
            <th>Tipo doc.</th>
            <th>Rol</th>
            <th>Código de acceso</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usuarios as $usuario): ?>
            <tr class="text-center">
              <!-- Se muestra cada dato del usuario en su columna correspondiente -->
              <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
              <td><?= htmlspecialchars($usuario['Nombres_usuario'] . ' ' . $usuario['Apellidos_usuario']) ?></td>
              <td><?= htmlspecialchars($usuario['Correo_Electronico']) ?></td>
              <td><?= htmlspecialchars($usuario['Celular']) ?></td>
              <td><?= htmlspecialchars($usuario['Edad']) ?></td>
              <td><?= obtenerNombreTipoDocumento($usuario['tipo_documento']) ?></td>
              <td><?= htmlspecialchars($usuario['Rol']) ?></td>
              <td><?= htmlspecialchars($usuario['cod_acceso']) ?></td>
              <td>
                <!-- Botones de acción para editar y eliminar -->
                <a href="editar_usuario.php?id=<?= $usuario['id_usuario'] ?>" class="btn btn-sm btn-primary mb-1">✏️ Editar</a>
                <a href="eliminar_usuario.php?id=<?= $usuario['id_usuario'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">🗑️ Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <!-- Botones para registrar usuario nuevo o volver al panel -->
  <div class="d-flex justify-content-center mt-4 gap-3">
    <a href="registro_usuario.php" class="btn btn-success">➕ Registrar nuevo usuario</a>
    <a href="admin.php" class="btn btn-secondary">← Volver al panel del administrador</a>
  </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Script para filtrar usuarios en la tabla mientras se escribe en el campo de búsqueda
document.getElementById('buscarInput').addEventListener('input', function () {
  const texto = this.value.toLowerCase();
  const filas = document.querySelectorAll('#tablaUsuarios tbody tr');

  filas.forEach(fila => {
    const contenidoFila = fila.textContent.toLowerCase();
    fila.style.display = contenidoFila.includes(texto) ? '' : 'none';
  });
});
</script>
</body>
</html>

