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
    <title>Reportes - Campo Verde</title>
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
                    <h3 class="text-success mb-4">Mis Reportes</h3>

                    <div class="mb-5">
                        <h5>Historial de Reportes Enviados</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Área</th>
                                        <th>Estado</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2025-07-10</td>
                                        <td>Jardines</td>
                                        <td>En revisión</td>
                                        <td>Fuga de agua cerca de las bancas.</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>2025-06-28</td>
                                        <td>Parque infantil</td>
                                        <td>Resuelto</td>
                                        <td>Columpio roto representa un peligro para los niños.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5>Registrar Nuevo Reporte</h5>
                        <form action="/api/reportes" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="area" class="form-label">Área Afectada</label>
                                <select class="form-select" id="area" name="area" required>
                                    <option value="">Selecciona</option>
                                    <option value="jardines">Jardines</option>
                                    <option value="parque infantil">Parque Infantil</option>
                                    <option value="gimnasio">Gimnasio</option>
                                    <option value="zonas comunes">Zonas Comunes</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describa el problema con detalle..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto del Problema (opcional)</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-success">Enviar Reporte</button>
                        </form>
                    </div>
                </section>
            </main>

            <?php include 'components/footer.html'; ?>
        </div>
    </div>
</body>
</html>
