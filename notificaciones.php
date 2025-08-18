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
    <title>Campo Verde - Notificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1">
        <?php include 'components/aside.php'; ?>

        <div class="d-flex flex-column flex-grow-1">
            <?php include 'components/header.php'; ?>

            <main class="flex-grow-1">
                <section class="container my-5">
                    <h2 class="mb-4">Configuración de Notificaciones</h2>
                    <div class="list-group">
                        <label class="list-group-item d-flex gap-2">
                            <input class="form-check-input flex-shrink-0" type="checkbox" name="listGroupChecks" id="listGroupChecks1" checked>
                            <span>
                                Alertas de pago
                                <small class="d-block text-body-secondary">Notificaciones para indicar que ya se puede realizar el pago de la mensualidad</small>
                            </span>
                        </label>
                        <label class="list-group-item d-flex gap-2">
                            <input class="form-check-input flex-shrink-0" type="checkbox" name="listGroupChecks" id="listGroupChecks2">
                            <span>
                                Alertas de pago atrasado
                                <small class="d-block text-body-secondary">Notificaciones cuando el pago está atrasado</small>
                            </span>
                        </label>
                        <label class="list-group-item d-flex gap-2">
                            <input class="form-check-input flex-shrink-0" type="checkbox" name="listGroupChecks" id="listGroupChecks3">
                            <span>
                                Alertas de mantenimiento
                                <small class="d-block text-body-secondary">Notificaciones sobre trabajos de mantenimiento programados</small>
                            </span>
                        </label>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <?php include 'components/footer.html'; ?>
</body>
</html>
