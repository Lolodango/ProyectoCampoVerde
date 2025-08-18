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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagos | Campo Verde</title>
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
                <section class="container mt-4">
                    <h3 class="text-success mb-4">Pagos de Mantenimiento</h3>

                    <div class="card border border-warning shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark fw-bold d-flex align-items-center">
                            <i class="bi bi-exclamation-circle me-2"></i> Pago Pendiente
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="card-title mb-2">Cuota de mantenimiento - Julio 2025</h5>
                                    <ul class="list-unstyled mb-3">
                                        <li><strong>Fecha límite:</strong> 25 de julio, 2025</li>
                                        <li><strong>Monto:</strong> ₡35,000</li>
                                        <li><strong>Estado:</strong> <span class="badge bg-warning text-dark">Pendiente</span></li>
                                    </ul>
                                </div>
                                <div class="col-md-4 text-md-end text-center">
                                    <a href="realizar_pago.html" class="btn btn-success btn-lg w-100 mt-2">💳 Pagar ahora</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-3">Historial de Pagos</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha de Pago</th>
                                    <th>Mes</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Comprobante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>2025-06-25</td>
                                    <td>Junio</td>
                                    <td>₡35,000</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
                                    <td><a href="#">Ver</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2025-05-25</td>
                                    <td>Mayo</td>
                                    <td>₡35,000</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
                                    <td><a href="#">Ver</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2025-04-25</td>
                                    <td>Abril</td>
                                    <td>₡35,000</td>
                                    <td><span class="badge bg-success">Pagado</span></td>
                                    <td><a href="#">Ver</a></td>
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
