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
    <title>Administrador - Quejas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/script_quejas_admin.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1">
        <?php include 'components/aside.php'; ?>

        <div class="d-flex flex-column flex-grow-1">
            <?php include 'components/header.php'; ?>

            <main class="flex-grow-1">
                <section class="container mt-4">
                    <h3 class="text-success mb-4">Todas las Quejas de Usuarios</h3>

                    <div class="mb-3">
                        <button class="btn btn-outline-success me-2 filtro-btn active" data-filtro="todas">Todas</button>
                        <button class="btn btn-outline-warning me-2 filtro-btn" data-filtro="pendiente">Pendientes</button>
                        <button class="btn btn-outline-primary me-2 filtro-btn" data-filtro="enrevision">En revisión</button>
                        <button class="btn btn-outline-success me-2 filtro-btn" data-filtro="resuelta">Resueltas</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="tablaQuejas">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-estado="enrevision">
                                    <td>1</td>
                                    <td>Edcelth Jimenez</td>
                                    <td>2025-07-05</td>
                                    <td>Ruido excesivo</td>
                                    <td>Música alta en el bloque B hasta la madrugada.</td>
                                    <td><span class="badge bg-primary">En revisión</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary">Cambiar estado</button></td>
                                </tr>
                                <tr data-estado="resuelta">
                                    <td>2</td>
                                    <td>Ana Rodríguez</td>
                                    <td>2025-07-03</td>
                                    <td>Basura en pasillos</td>
                                    <td>Acumulación de basura frente al bloque C.</td>
                                    <td><span class="badge bg-success">Resuelta</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary">Cambiar estado</button></td>
                                </tr>
                                <tr data-estado="pendiente">
                                    <td>3</td>
                                    <td>Carlos Méndez</td>
                                    <td>2025-07-01</td>
                                    <td>Fugas de agua</td>
                                    <td>Fuga cerca del parqueadero norte.</td>
                                    <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary">Cambiar estado</button></td>
                                </tr>
                                <tr data-estado="resuelta">
                                    <td>4</td>
                                    <td>Laura Salas</td>
                                    <td>2025-06-28</td>
                                    <td>Luces apagadas</td>
                                    <td>Sin iluminación en el sendero principal.</td>
                                    <td><span class="badge bg-success">Resuelta</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary">Cambiar estado</button></td>
                                </tr>
                                <tr data-estado="pendiente">
                                    <td>5</td>
                                    <td>Pedro Gómez</td>
                                    <td>2025-06-25</td>
                                    <td>Animales sueltos</td>
                                    <td>Perros sin correa en zona infantil.</td>
                                    <td><span class="badge bg-warning text-dark">Pendiente</span></td>
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
