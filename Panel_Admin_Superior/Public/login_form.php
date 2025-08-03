<!DOCTYPE html>
<html lang="es"> <!-- ✅ Página en español -->
<head>
  <meta charset="UTF-8"> <!-- ✅ Codificación de caracteres correcta -->
  <title>Login - Cafetería Ebenezer</title> <!-- ✅ Título de la pestaña -->

  <!-- ✅ Bootstrap 5 para estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa; /* ✅ Color de fondo claro */
    }
    .login-box {
      max-width: 400px; /* ✅ Ancho máximo del formulario */
      margin: 80px auto; /* ✅ Centrado vertical y horizontal */
      padding: 30px;
      border-radius: 10px;
      background-color: white; /* ✅ Fondo blanco del cuadro */
      box-shadow: 0 0 15px rgba(0,0,0,0.1); /* ✅ Sombra sutil */
    }
  </style>
</head>
<body>
    
  <div class="container">
    <div class="login-box">
      <h3 class="text-center mb-4">🔐 Iniciar sesión</h3> <!-- ✅ Encabezado visual -->

      <!-- ✅ Formulario de inicio de sesión -->
      <form action="login.php" method="POST"> <!-- ✅ Envia datos al script PHP login.php -->
        <div class="mb-3">
          <label for="correo" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" id="correo" name="correo" required> <!-- ✅ Campo tipo email obligatorio -->
        </div>

        <div class="mb-3">
          <label for="celular" class="form-label">Número de celular</label>
          <input type="text" class="form-control" id="celular" name="celular" required> <!-- ❌ El tipo "text" no valida si es número real -->
          <!-- ❌ Podría usarse type="tel" o agregar patrón para validación de números -->
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Ingresar</button> <!-- ✅ Botón de envío -->
        </div>
      </form>

      <?php if (isset($_SESSION['error_login'])): ?> <!-- ✅ Verifica si hay error guardado en sesión -->
        <div class="alert alert-danger mt-3">
          <?= $_SESSION['error_login'] ?> <!-- ✅ Muestra el mensaje de error -->
          <?php unset($_SESSION['error_login']); ?> <!-- ✅ Limpia el error de sesión después de mostrarlo -->
        </div>
      <?php endif; ?>
      <!-- ❌ No se muestra si $_SESSION no fue inicializado previamente con session_start() -->
    </div>
  </div>
</body>
</html>
