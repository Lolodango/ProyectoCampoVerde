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
    <title>Mis Quejas | Campo Verde</title>
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
                <section class="container mt-4">
                    <h3 class="text-success mb-4">Mis Quejas</h3>

                    <div class="mb-5">
                        <h5>Historial de Quejas Enviadas</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Título</th>
                                        <th>Estado</th>
                                        <th>Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2025-07-05</td>
                                        <td>Ruido excesivo</td>
                                        <td>En revisión</td>
                                        <td>Los vecinos del bloque B han tenido música alta hasta la madrugada.</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>2025-06-22</td>
                                        <td>Basura en áreas comunes</td>
                                        <td>Resuelta</td>
                                        <td>Hay acumulación de basura cerca del parque infantil.</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>2025-05-14</td>
                                        <td>Luces apagadas en sendero</td>
                                        <td>Resuelta</td>
                                        <td>El sendero detrás del gimnasio está completamente a oscuras por la noche.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5>Registrar Nueva Queja</h5>
                        <form>
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" placeholder="Ej: Ruido excesivo en la noche" required>
                            </div>
                            <div class="mb-3">
                                <label for="detalle" class="form-label">Descripción</label>
                                <textarea class="form-control" id="detalle" rows="4" placeholder="Escriba aquí su queja..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Enviar Queja</button>
                        </form>
                    </div>
                </section>
            </main>

            <?php include 'components/footer.html'; ?>
        </div>
    </div>
</body>
</html>
