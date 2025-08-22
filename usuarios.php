<?php
/***********************
 *  GUARDIAS DE SESIÓN *
 ***********************/
session_start();
if (empty($_SESSION['usuario'])) {
    header("Location: login.php"); exit;
}

// SOLO ADMIN (id_rol = 1). Acepta también 'Administrador' por compatibilidad.
$rol = $_SESSION['rol'] ?? null;
$esAdmin = ($rol === 1 || $rol === '1' || $rol === 'Administrador');
if (!$esAdmin) {
    header("Location: dashboard.php"); exit;
}

/***********************
 *  CONEXIÓN (PDO)     *
 ***********************/
require_once __DIR__ . '/database.php';
$pdo = Database::getInstance()->pdo();

/***********************************
 *  CARGAR ROLES PARA LOS SELECT   *
 ***********************************/
$roles = $pdo->query("SELECT id_rol, nombre_rol FROM Rol ORDER BY id_rol")->fetchAll(PDO::FETCH_ASSOC);

/***********************
 *  HANDLERS (CRUD)    *
 ***********************/

// AGREGAR USUARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'agregar') {
    $cedula           = trim($_POST['cedula'] ?? '');
    $nombre           = trim($_POST['nombre'] ?? '');
    $primer_apellido  = trim($_POST['primer_apellido'] ?? '');
    $segundo_apellido = trim($_POST['segundo_apellido'] ?? '');
    $nombre_usuario   = trim($_POST['nombre_usuario'] ?? '');
    $correo           = trim($_POST['correo'] ?? '');
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
    $numero_casa      = trim($_POST['numero_casa'] ?? '');
    $id_rol           = (int)($_POST['id_rol'] ?? 2);
    $contrasena_plana = $_POST['contrasena'] ?? '';

    // Validaciones mínimas
    if ($cedula==='' || $nombre==='' || $primer_apellido==='' || $nombre_usuario==='' ||
        $correo==='' || !$fecha_nacimiento || $numero_casa==='') {
        header("Location: usuarios.php?err=Faltan+campos+requeridos"); exit;
    }

    $hash = password_hash($contrasena_plana !== '' ? $contrasena_plana : '123456', PASSWORD_BCRYPT);

    $sql = "INSERT INTO Usuarios
      (cedula, nombre, primer_apellido, segundo_apellido, nombre_usuario, contrasena,
       correo, fecha_nacimiento, id_rol, id_estado, numero_casa)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            $cedula, $nombre, $primer_apellido, $segundo_apellido, $nombre_usuario,
            $hash, $correo, $fecha_nacimiento, $id_rol, $numero_casa
        ]);
        header("Location: usuarios.php?ok=creado"); exit;
    } catch (PDOException $e) {
        // 1062 = duplicado (cedula PK / nombre_usuario UNIQUE / numero_casa UNIQUE)
        if (($e->errorInfo[1] ?? 0) == 1062) {
            header("Location: usuarios.php?err=Usuario/casa/cédula+ya+existe"); exit;
        }
        error_log($e->getMessage());
        header("Location: usuarios.php?err=Error+al+crear"); exit;
    }
}

// EDITAR USUARIO (por cédula)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'editar') {
    $cedula           = trim($_POST['cedula'] ?? '');
    $nombre           = trim($_POST['nombre'] ?? '');
    $primer_apellido  = trim($_POST['primer_apellido'] ?? '');
    $segundo_apellido = trim($_POST['segundo_apellido'] ?? '');
    $nombre_usuario   = trim($_POST['nombre_usuario'] ?? '');
    $correo           = trim($_POST['correo'] ?? '');
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
    $numero_casa      = trim($_POST['numero_casa'] ?? '');
    $id_rol           = (int)($_POST['id_rol'] ?? 2);
    $id_estado        = (int)($_POST['id_estado'] ?? 1);
    $contrasena_plana = $_POST['contrasena'] ?? '';

    if ($cedula==='') { header("Location: usuarios.php?err=Falta+cedula"); exit; }

    // Armado dinámico si viene nueva contraseña
    $set  = "nombre=?, primer_apellido=?, segundo_apellido=?, nombre_usuario=?, correo=?, fecha_nacimiento=?, id_rol=?, id_estado=?, numero_casa=?";
    $args = [$nombre, $primer_apellido, $segundo_apellido, $nombre_usuario, $correo, $fecha_nacimiento, $id_rol, $id_estado, $numero_casa];

    if ($contrasena_plana !== '') {
        $set .= ", contrasena=?";
        $args[] = password_hash($contrasena_plana, PASSWORD_BCRYPT);
    }
    $args[] = $cedula;

    $stmt = $pdo->prepare("UPDATE Usuarios SET $set WHERE cedula=?");
    try {
        $stmt->execute($args);
        header("Location: usuarios.php?ok=editado"); exit;
    } catch (PDOException $e) {
        if (($e->errorInfo[1] ?? 0) == 1062) {
            header("Location: usuarios.php?err=Usuario/casa+ya+existe"); exit;
        }
        error_log($e->getMessage());
        header("Location: usuarios.php?err=Error+al+editar"); exit;
    }
}

// ELIMINAR LÓGICO (id_estado=2)
if (isset($_GET['eliminar'])) {
    $cedula = trim($_GET['eliminar']);
    $stmt = $pdo->prepare("UPDATE Usuarios SET id_estado = 2 WHERE cedula = ?");
    $stmt->execute([$cedula]);
    header("Location: usuarios.php?ok=eliminado"); exit;
}

/***********************
 *  LISTADO            *
 ***********************/
$sql = "
  SELECT u.cedula,
         u.nombre, u.primer_apellido, u.segundo_apellido,
         u.nombre_usuario, u.correo, u.fecha_nacimiento,
         u.numero_casa, u.id_rol, u.id_estado,
         COALESCE(r.nombre_rol, u.id_rol) AS nombre_rol
  FROM Usuarios u
  LEFT JOIN Rol r ON r.id_rol = u.id_rol
  ORDER BY u.nombre, u.primer_apellido, u.cedula
";
$rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Usuarios - Campo Verde</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
  <div class="d-flex flex-grow-1">
    <?php include 'components/aside.php'; ?>

    <div class="d-flex flex-column flex-grow-1">
      <?php include 'components/header.php'; ?>

      <main class="flex-grow-1">
        <div class="container mt-4">

          <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-success">Gestión de Usuarios</h3>
            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">➕ Añadir Usuario</button>
          </div>

          <?php if (isset($_GET['ok'])): ?>
            <div class="alert alert-success">Acción realizada: <?= htmlspecialchars($_GET['ok']) ?></div>
          <?php endif; ?>
          <?php if (isset($_GET['err'])): ?>
            <div class="alert alert-danger">Error: <?= htmlspecialchars($_GET['err']) ?></div>
          <?php endif; ?>

          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="table-success">
                <tr>
                  <th>Cédula</th>
                  <th>Nombre</th>
                  <th>Usuario</th>
                  <th>Correo</th>
                  <th>Casa</th>
                  <th>Rol</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php if (!$rows): ?>
                <tr><td colspan="8" class="text-center">No hay usuarios</td></tr>
              <?php else: foreach ($rows as $row): ?>
                <tr>
                  <td><?= htmlspecialchars($row['cedula']) ?></td>
                  <td><?= htmlspecialchars($row['nombre'].' '.$row['primer_apellido'].' '.$row['segundo_apellido']) ?></td>
                  <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                  <td><?= htmlspecialchars($row['correo']) ?></td>
                  <td><?= htmlspecialchars($row['numero_casa']) ?></td>
                  <td><?= htmlspecialchars($row['nombre_rol']) ?></td>
                  <td><?= ((int)$row['id_estado'] === 1 ? 'Activo' : 'Inactivo') ?></td>
                  <td class="text-nowrap">
                    <button
                      class="btn btn-warning btn-sm editarBtn"
                      data-cedula="<?= htmlspecialchars($row['cedula']) ?>"
                      data-nombre="<?= htmlspecialchars($row['nombre']) ?>"
                      data-pape="<?= htmlspecialchars($row['primer_apellido']) ?>"
                      data-sape="<?= htmlspecialchars($row['segundo_apellido']) ?>"
                      data-user="<?= htmlspecialchars($row['nombre_usuario']) ?>"
                      data-correo="<?= htmlspecialchars($row['correo']) ?>"
                      data-fnac="<?= htmlspecialchars($row['fecha_nacimiento']) ?>"
                      data-casa="<?= htmlspecialchars($row['numero_casa']) ?>"
                      data-rol="<?= (int)$row['id_rol'] ?>"
                      data-estado="<?= (int)$row['id_estado'] ?>"
                      data-bs-toggle="modal" data-bs-target="#modalEditarUsuario"
                    >✏️</button>

                    <a href="usuarios.php?eliminar=<?= urlencode($row['cedula']) ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar este usuario?')">❌</a>
                  </td>
                </tr>
              <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </main>

      <!-- Modal Añadir Usuario -->
      <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="post">
              <input type="hidden" name="accion" value="agregar">
              <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalAgregarLabel">Añadir Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="row g-2">
                  <div class="col-md-4">
                    <label class="form-label">Cédula</label>
                    <input type="text" class="form-control" name="cedula" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" name="primer_apellido" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" name="segundo_apellido">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="nombre_usuario" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input type="email" class="form-control" name="correo" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Fecha Nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Casa</label>
                    <input type="text" class="form-control" name="numero_casa" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Rol</label>
                    <select class="form-select" name="id_rol" required>
                      <?php foreach ($roles as $r): ?>
                        <option value="<?= (int)$r['id_rol'] ?>"><?= htmlspecialchars($r['nombre_rol']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-8">
                    <label class="form-label">Contraseña (opcional, por defecto 123456)</label>
                    <input type="password" class="form-control" name="contrasena" placeholder="Dejar vacío para 123456">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal Editar Usuario -->
      <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form method="post">
              <input type="hidden" name="accion" value="editar">
              <input type="hidden" name="cedula" id="e_cedula">
              <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditarLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="row g-2">
                  <div class="col-md-4">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="e_nombre" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" name="primer_apellido" id="e_pape" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" name="segundo_apellido" id="e_sape">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="nombre_usuario" id="e_user" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input type="email" class="form-control" name="correo" id="e_correo" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Fecha Nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento" id="e_fnac" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Casa</label>
                    <input type="text" class="form-control" name="numero_casa" id="e_casa" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Rol</label>
                    <select class="form-select" name="id_rol" id="e_rol" required>
                      <?php foreach ($roles as $r): ?>
                        <option value="<?= (int)$r['id_rol'] ?>"><?= htmlspecialchars($r['nombre_rol']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select class="form-select" name="id_estado" id="e_estado" required>
                      <option value="1">Activo</option>
                      <option value="2">Inactivo</option>
                    </select>
                  </div>
                  <div class="col-md-8">
                    <label class="form-label">Nueva contraseña (opcional)</label>
                    <input type="password" class="form-control" name="contrasena" placeholder="Dejar vacío para no cambiar">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-warning text-white">Guardar Cambios</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <?php include 'components/footer.html'; ?>
    </div>
  </div>

  <script>
  // Rellenar modal de edición con los datos del botón
  document.querySelectorAll('.editarBtn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('e_cedula').value = this.dataset.cedula;
      document.getElementById('e_nombre').value = this.dataset.nombre;
      document.getElementById('e_pape').value   = this.dataset.pape;
      document.getElementById('e_sape').value   = this.dataset.sape || '';
      document.getElementById('e_user').value   = this.dataset.user;
      document.getElementById('e_correo').value = this.dataset.correo;
      document.getElementById('e_fnac').value   = this.dataset.fnac;
      document.getElementById('e_casa').value   = this.dataset.casa;
      document.getElementById('e_rol').value    = this.dataset.rol;
      document.getElementById('e_estado').value = this.dataset.estado;
    });
  });
  </script>
</body>
</html>
