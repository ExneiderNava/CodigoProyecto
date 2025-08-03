<!-- Vista/Usuario/editar.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>

    <!-- Estilos internos para la vista de edición de usuario -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #fff;
            max-width: 600px;
            margin: 50px auto;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        h4 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Título principal de la página -->
        <h4>✏️ Editar Usuario</h4>

        <!-- Formulario para editar datos del usuario -->
        <form action="/proyecto_F2/Panel_Admin_Superior/Public/editar_usuario.php?accion=actualizar" method="POST">

            <!-- Campo oculto con el ID del usuario a editar -->
            <input type="hidden" name="Id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">

            <!-- Selección del tipo de documento -->
            <div>
                <label for="tipo_documento" class="form-label">Tipo de documento</label>
                <select name="tipo_documento" class="form-control" required>
                    <option value="1" <?= $usuario['tipo_documento'] == '1' ? 'selected' : '' ?>>Cédula (CC)</option>
                    <option value="2" <?= $usuario['tipo_documento'] == '2' ? 'selected' : '' ?>>Tarjeta de Identidad (TI)</option>
                    <option value="3" <?= $usuario['tipo_documento'] == '3' ? 'selected' : '' ?>>Permiso temporal (PPT)</option>
                </select>
            </div>

            <!-- Campo para nombres -->
            <div>
                <label class="form-label">Nombres</label>
                <input type="text" name="Nombres_usuario" class="form-control" value="<?= htmlspecialchars($usuario['Nombres_usuario']) ?>" required>
            </div>

            <!-- Campo para apellidos -->
            <div>
                <label class="form-label">Apellidos</label>
                <input type="text" name="Apellidos_usuario" class="form-control" value="<?= htmlspecialchars($usuario['Apellidos_usuario']) ?>" required>
            </div>

            <!-- Selección de rol del usuario -->
            <div>
                <label class="form-label">Rol</label>
                <select name="Rol" class="form-control" required>
                    <option value="Estudiante" <?= $usuario['Rol'] === 'Estudiante' ? 'selected' : '' ?>>Estudiante</option>
                    <option value="Profesor" <?= $usuario['Rol'] === 'Profesor' ? 'selected' : '' ?>>Profesor</option>
                    <option value="Empleado" <?= $usuario['Rol'] === 'Empleado' ? 'selected' : '' ?>>Empleado</option>
                    <option value="Administrador" <?= $usuario['Rol'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>

            <!-- Campo para edad -->
            <div>
                <label class="form-label">Edad</label>
                <input type="number" name="Edad" class="form-control" value="<?= htmlspecialchars($usuario['Edad']) ?>" required>
            </div>

            <!-- Campo para celular -->
            <div>
                <label class="form-label">Celular</label>
                <input type="text" name="Celular" class="form-control" value="<?= htmlspecialchars($usuario['Celular']) ?>" required>
            </div>

            <!-- Campo para correo electrónico -->
            <div>
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="Correo_Electronico" class="form-control" value="<?= htmlspecialchars($usuario['Correo_Electronico']) ?>" required>
            </div>

            <!-- Campo para código de acceso -->
            <div>
                <label class="form-label">Código de acceso</label>
                <input type="text" name="cod_acceso" class="form-control" value="<?= htmlspecialchars($usuario['cod_acceso']) ?>" required>
            </div>

            <!-- Botones para guardar o cancelar la edición -->
            <div class="d-flex mt-3">
                <button type="submit" class="btn btn-success">💾 Guardar cambios</button>
                <a href="/Proyecto_F2/Panel_Admin_Superior/Public/ver_usuarios.php" class="btn btn-danger">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>





