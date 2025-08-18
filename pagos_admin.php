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
    <title>Administrador - Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/script_pagos_admin.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1">
        <?php include 'components/aside.php'; ?>

        <div class="d-flex flex-column flex-grow-1">
            <?php include 'components/header.php'; ?>

            <main class="flex-grow-1">
                <section class="container mt-4">
                    <h3 class="text-success mb-4">Pagos de Usuarios</h3>

                    <div class="mb-3">
                        <button class="btn btn-outline-success me-2 filtro-btn active" data-filtro="todos">Todos</button>
                        <button class="btn btn-outline-warning me-2 filtro-btn" data-filtro="pendiente">Pendientes</button>
                        <button class="btn btn-outline-primary me-2 filtro-btn" data-filtro="pagado">Pagados</button>
                        <button class="btn btn-outline-danger me-2 filtro-btn" data-filtro="atrasado">Atrasados</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="tablaPagos">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Mes</th>
                                    <th>Fecha Límite</th>
                                    <th>Estado</th>
                                    <th>Monto</th>
                                    <th>Comprobante</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-estado="pendiente">
                                    <td>1</td>
                                    <td>Edcelth Jimenez</td>
                                    <td>Julio</td>
                                    <td>2025-07-25</td>
                                    <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                                    <td>₡35,000</td>
                                    <td>-</td>
                                    <td><button class="btn btn-sm btn-outline-success">Marcar como pagado</button></td>
                                </tr>
                                <tr data-estado="pagado">
                                    <td>2</td>
                                    <td>Ana Rodríguez</td>
                                    <td>Junio</td>
                                    <td>2025-06-25</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
                                    <td>₡35,000</td>
                                    <td><a href="#">Ver</a></td>
                                    <td>-</td>
                                </tr>
                                <tr data-estado="atrasado">
                                    <td>3</td>
                                    <td>Carlos Méndez</td>
                                    <td>Julio</td>
                                    <td>2025-07-05</td>
                                    <td><span class="badge bg-danger">Atrasado</span></td>
                                    <td>₡35,000</td>
                                    <td>-</td>
                                    <td><button class="btn btn-sm btn-outline-success">Marcar como pagado</button></td>
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
