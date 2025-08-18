<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Administrador - Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/script_reportes_admin.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1">
        <?php include 'components/aside.php'; ?>

        <div class="d-flex flex-column flex-grow-1">
            <?php include 'components/header.php'; ?>

            <main class="flex-grow-1">
                <section class="container mt-4">
                    <h3 class="text-success mb-4">Todos los Reportes de Usuarios</h3>

                    <div class="mb-3">
                        <button class="btn btn-outline-success me-2 filtro-btn active" data-filtro="todas">Todos</button>
                        <button class="btn btn-outline-warning me-2 filtro-btn" data-filtro="pendiente">Pendientes</button>
                        <button class="btn btn-outline-primary me-2 filtro-btn" data-filtro="enrevision">En revisión</button>
                        <button class="btn btn-outline-success me-2 filtro-btn" data-filtro="resuelto">Resueltos</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="tablaReportes">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Área</th>
                                    <th>Descripción</th>
                                    <th>Foto</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-estado="pendiente">
                                    <td>1</td>
                                    <td>Edcelth Jimenez</td>
                                    <td>2025-07-10</td>
                                    <td>Jardines</td>
                                    <td>Fuga de agua cerca de las bancas.</td>
                                    <td><a href="fotos/fuga1.jpg" target="_blank">Ver Foto</a></td>
                                    <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary">Cambiar estado</button></td>
                                </tr>
                                <tr data-estado="resuelto">
                                    <td>2</td>
                                    <td>Ana Rodríguez</td>
                                    <td>2025-07-05</td>
                                    <td>Parque Infantil</td>
                                    <td>Columpio roto representa un peligro para los niños.</td>
                                    <td><a href="fotos/columpio.jpg" target="_blank">Ver Foto</a></td>
                                    <td><span class="badge bg-success">Resuelto</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary">Cambiar estado</button></td>
                                </tr>
                                <tr data-estado="enrevision">
                                    <td>3</td>
                                    <td>Carlos Méndez</td>
                                    <td>2025-07-03</td>
                                    <td>Sendero</td>
                                    <td>Luces apagadas en la zona de acceso nocturno.</td>
                                    <td><a href="fotos/sendero.jpg" target="_blank">Ver Foto</a></td>
                                    <td><span class="badge bg-primary">En revisión</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary">Cambiar estado</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>

            <?php include 'components/footer.html'; ?>
        </div>
    </div>
</body>
</html>
