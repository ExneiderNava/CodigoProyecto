<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Configuración de codificación y título -->
  <meta charset="UTF-8">
  <title>Registrar Producto</title>

  <!-- Enlace a Bootstrap para estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Contenedor principal -->
<div class="container mt-5">
  <!-- Título principal -->
  <h2 class="mb-4 text-center">📦 Registrar nuevo producto</h2>

  <?php if ($mensaje === 'exito'): ?>
    <!-- Alerta de éxito si el producto se registró correctamente -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      ✅ <strong>Producto registrado correctamente.</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  <?php elseif ($mensaje === 'error'): ?>
    <!-- Alerta de error si hubo problema al registrar el producto -->
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      ❌ <strong>Error al registrar el producto.</strong> Intenta nuevamente.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  <?php endif; ?>

  <!-- Formulario para registrar producto -->
  <form action="producto.php" method="POST" enctype="multipart/form-data" class="row g-3 mb-4">
    <!-- Campo: Nombre del producto -->
    <div class="col-md-6">
      <label class="form-label">Nombre del producto</label>
      <input type="text" class="form-control" name="Nombre_Producto" required>
    </div>

    <!-- Campo: ID del producto -->
    <div class="col-md-6">
      <label class="form-label">Código del producto (ID)</label>
      <input type="text" class="form-control" name="Id_Producto" required>
    </div>

    <!-- Campo: Precio de costo -->
    <div class="col-md-6">
      <label class="form-label">Precio de costo</label>
      <input type="number" step="0.01" class="form-control" name="Precio_costo" required>
    </div>

    <!-- Campo: Precio de venta -->
    <div class="col-md-6">
      <label class="form-label">Precio de venta</label>
      <input type="number" step="0.01" class="form-control" name="Precio_venta" required>
    </div>

    <!-- Campo: Cantidad en stock -->
    <div class="col-md-6">
      <label class="form-label">Cantidad en stock</label>
      <input type="number" class="form-control" name="Cantidad_en_Stock" required>
    </div>

    <!-- Campo: Categoría del producto -->
    <div class="col-md-6">
      <label class="form-label">Categoría</label>
      <select class="form-select" name="Tipo_Producto" required>
        <option value="">Seleccione</option>
        <option value="1">Snacks</option>
        <option value="2">Bebidas</option>
        <option value="3">Comidas</option>
        <option value="4">Postres</option>
        <option value="5">Otros</option>
      </select>
    </div>

    <!-- Campo: Selección de proveedor -->
    <div class="col-md-12">
      <label class="form-label">Proveedor</label>
      <select class="form-select" name="Id_Proveedor" required>
        <option value="">Seleccione un proveedor</option>
        <?php foreach ($proveedores as $prov): ?>
          <option value="<?= $prov['id_proveedor'] ?>">
            <?= htmlspecialchars($prov['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Campo: Imagen del producto -->
    <div class="col-md-12">
      <label class="form-label">Foto del producto</label>
      <input type="file" class="form-control" name="foto" accept="image/*" required>
    </div>

    <!-- Botón para enviar formulario -->
    <div class="col-12 text-center">
      <button type="submit" name="registrar" class="btn btn-success">➕ Guardar producto</button>
    </div>
  </form>

  <!-- Botones de navegación -->
  <div class="text-center mb-4">
    <a href="producto.php?listar=1" class="btn btn-info">📋 Ver productos registrados</a>
    <a href="admin.php" class="btn btn-secondary">← Volver al panel del administrador</a>
  </div>

  <!-- Tabla de productos registrados -->
  <?php if (!empty($productos)): ?>
  <div class="card mt-4">
    <div class="card-header bg-info text-white">
      Productos registrados
    </div>
    <div class="card-body">

      <!-- Buscador de productos -->
      <input type="text" id="buscador" class="form-control mb-3" placeholder="🔎 Buscar producto por nombre...">

      <!-- Tabla de productos -->
<table id="tablaProductos" class="table table-striped table-bordered table-hover">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Precio venta</th>
      <th>Precio costo</th>
      <th>Cantidad</th>
      <th>Categoría</th>
      <th>Foto</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <!-- Ciclo para mostrar los productos -->
    <?php foreach ($productos as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['Id_Producto']) ?></td>
        <td><?= htmlspecialchars($p['Nombre_Producto']) ?></td>
        <td>$<?= number_format($p['Precio_venta'], 0, ',', '.') ?></td>
        <td>$<?= number_format($p['Precio_costo'], 0, ',', '.') ?></td>
        <td><?= $p['Cantidad_en_Stock'] ?></td>
        <td><?= $p['Tipo_Producto'] ?></td>
        <td>
          <?php if (!empty($p['Foto'])): ?>
            <!-- Muestra imagen codificada en base64 -->
            <img src="data:image/jpeg;base64,<?= base64_encode($p['Foto']) ?>" width="60" height="60" style="object-fit:cover;">
          <?php else: ?>
            <span class="text-muted">Sin imagen</span>
          <?php endif; ?>
        </td>
        <td>
          <!-- Botón para abrir el modal y agregar unidades -->
          <button 
            class="btn btn-sm btn-success mb-1" 
            onclick="abrirModal('<?= $p['Id_Producto'] ?>', '<?= htmlspecialchars($p['Nombre_Producto']) ?>')">
            ➕ Agregar unidades
          </button>

         <!-- Botón para abrir el modal de edición con los datos actuales -->
        <button class="btn btn-sm btn-primary mb-1"
          onclick="abrirModalEditar(
            '<?= $p['Id_Producto'] ?>',
            '<?= htmlspecialchars($p['Nombre_Producto'], ENT_QUOTES) ?>',
            '<?= $p['Precio_venta'] ?>',
            '<?= $p['Precio_costo'] ?>',
            '<?= $p['Cantidad_en_Stock'] ?>',
            '<?= htmlspecialchars($p['Tipo_Producto'], ENT_QUOTES) ?>'
            )">
            ✏️ Editar
        </button>


          <!-- Botón para eliminar producto -->
          <a href="producto.php?eliminar=<?= urlencode($p['Id_Producto']) ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('¿Está seguro de eliminar este producto?')">
            🗑️ Eliminar
          </a>
          
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
    </div>
  </div>

  <!-- Modal para agregar unidades al producto -->
  <div class="modal fade" id="modalUnidades" tabindex="-1" aria-labelledby="modalUnidadesLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="formAgregarUnidades" method="POST" action="producto.php" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUnidadesLabel">Agregar unidades</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <!-- Campo oculto con el ID del producto -->
          <input type="hidden" name="id_producto" id="modalIdProducto">
          <p>¿Cuántas unidades desea agregar a <strong id="modalNombreProducto"></strong>?</p>
          <!-- Campo para ingresar cantidad -->
          <input type="number" name="cantidad" class="form-control" min="1" required>
        </div>
        <div class="modal-footer">
          <!-- Botón para confirmar -->
          <button type="submit" class="btn btn-success" name="agregar_unidades" value="1">✅ Agregar</button>
          <!-- Botón para cerrar el modal -->
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Script para abrir el modal y pasar datos -->
  <script>
    function abrirModal(id, nombre) {
      document.getElementById('modalIdProducto').value = id;
      document.getElementById('modalNombreProducto').innerText = nombre;
      new bootstrap.Modal(document.getElementById('modalUnidades')).show();
    }

    // Buscador de productos por nombre
    document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('buscador');
      const filas = document.querySelectorAll("#tablaProductos tbody tr");

      input.addEventListener('input', function () {
        const filtro = this.value.toLowerCase();
        filas.forEach(fila => {
          const nombre = fila.children[1].textContent.toLowerCase();
          fila.style.display = nombre.includes(filtro) ? '' : 'none';
        });
      });
    });
  </script>

  <?php endif; ?>

  <!-- Modal para editar producto -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="producto.php" enctype="multipart/form-data" class="modal-content">
      <!-- Identificador de acción -->
      <input type="hidden" name="accion" value="editar">
      <!-- ID oculto del producto -->
      <input type="hidden" name="Id_Producto" id="edit_Id_Producto">

      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarLabel">Editar producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <!-- Campos del formulario que serán llenados dinámicamente -->
        <div class="mb-3">
          <label>Nombre del producto</label>
          <input type="text" name="Nombre_Producto" id="edit_Nombre_Producto" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Precio de venta</label>
          <input type="number" name="Precio_venta" id="edit_Precio_venta" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
          <label>Precio de costo</label>
          <input type="number" name="Precio_costo" id="edit_Precio_costo" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
          <label>Cantidad en stock</label>
          <input type="number" name="Cantidad_en_Stock" id="edit_Cantidad_en_Stock" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Categoría</label>
          <input type="text" name="Tipo_Producto" id="edit_Tipo_Producto" class="form-control" required>
        </div>
      </div>

      <div class="modal-footer">
        <!-- Botón para enviar cambios -->
        <button type="submit" class="btn btn-success">✅ Guardar cambios</button>
        <!-- Botón para cerrar -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

</div>

<script>
  // Función para abrir modal de edición con datos prellenados
  function abrirModalEditar(id, nombre, venta, costo, cantidad, tipo) {
    document.getElementById('edit_Id_Producto').value = id;
    document.getElementById('edit_Nombre_Producto').value = nombre;
    document.getElementById('edit_Precio_venta').value = venta;
    document.getElementById('edit_Precio_costo').value = costo;
    document.getElementById('edit_Cantidad_en_Stock').value = cantidad;
    document.getElementById('edit_Tipo_Producto').value = tipo;

    // Muestra el modal
    new bootstrap.Modal(document.getElementById('modalEditarProducto')).show();
  }
</script>


<!-- Script de Bootstrap para funcionalidades -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

