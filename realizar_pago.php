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
    <title>Realizar Pago | Campo Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/script_realizar_pago.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1">
        <?php include 'components/aside.php'; ?>

        <div class="d-flex flex-column flex-grow-1">
            <?php include 'components/header.php'; ?>

            <main class="flex-grow-1">
                <section class="container mt-4">
                    <h3 class="text-success mb-4">Realizar Pago</h3>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Resumen del Pago</h5>
                            <p><strong>Concepto:</strong> Cuota de mantenimiento - Julio 2025</p>
                            <p><strong>Monto:</strong> ₡35,000</p>
                            <p><strong>Fecha límite:</strong> 25 de julio, 2025</p>
                        </div>
                    </div>

                    <form method="POST" action="procesar_pago.php">
                        <div class="mb-3">
                            <label for="metodoPago" class="form-label">Método de Pago</label>
                            <select class="form-select" id="metodoPago" name="metodoPago" required>
                                <option value="">Selecciona una opción</option>
                                <option value="tarjeta">Tarjeta de crédito/débito</option>
                                <option value="transferencia">Transferencia bancaria</option>
                                <option value="sinpe">SINPE Móvil</option>
                            </select>
                        </div>

                        <div id="seccionTarjeta" style="display: none;">
                            <div class="mb-3">
                                <label for="numTarjeta" class="form-label">Número de tarjeta</label>
                                <input type="text" class="form-control" id="numTarjeta" name="numTarjeta" placeholder="#### #### #### ####">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fechaVenc" class="form-label">Fecha de vencimiento</label>
                                    <input type="text" class="form-control" id="fechaVenc" name="fechaVenc" placeholder="MM/AA">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Confirmar Pago</button>
                        <a href="pagos.php" class="btn btn-outline-secondary mt-3 ms-2">Cancelar</a>
                    </form>
                </section>
            </main>

            <?php include 'components/footer.html'; ?>
        </div>
    </div>
</body>
</html>
