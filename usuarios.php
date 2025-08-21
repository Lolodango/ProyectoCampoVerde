<?php
require_once __DIR__ . '/../../database.php';

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
                        <div>
                            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">➕ Añadir Usuario</button>
                            <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">✏️ Editar</button>
                            <button class="btn btn-danger">❌ Eliminar</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>Ana Morales</td><td>ana.morales@campoverde.com</td><td>Administrador</td><td>Activo</td></tr>
                                <tr><td>2</td><td>David Castro</td><td>david.castro@campoverde.com</td><td>Residente</td><td>Activo</td></tr>
                                <tr><td>3</td><td>Laura Sánchez</td><td>laura.sanchez@campoverde.com</td><td>Residente</td><td>Inactivo</td></tr>
                                <tr><td>4</td><td>José Herrera</td><td>jose.herrera@campoverde.com</td><td>Residente</td><td>Activo</td></tr>
                                <tr><td>5</td><td>Lucía Rojas</td><td>lucia.rojas@campoverde.com</td><td>Administrador</td><td>Activo</td></tr>
                                <tr><td>6</td><td>Manuel Vargas</td><td>manuel.vargas@campoverde.com</td><td>Residente</td><td>Inactivo</td></tr>
                                <tr><td>7</td><td>Carolina Jiménez</td><td>carolina.jimenez@campoverde.com</td><td>Residente</td><td>Activo</td></tr>
                                <tr><td>8</td><td>Esteban Navarro</td><td>esteban.navarro@campoverde.com</td><td>Residente</td><td>Activo</td></tr>
                                <tr><td>9</td><td>Sofía Campos</td><td>sofia.campos@campoverde.com</td><td>Administrador</td><td>Activo</td></tr>
                                <tr><td>10</td><td>Mario Fernández</td><td>mario.fernandez@campoverde.com</td><td>Residente</td><td>Inactivo</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <!-- Modal Añadir Usuario -->
            <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="modalAgregarLabel">Añadir Usuario</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Nombre completo">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" placeholder="Correo">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rol</label>
                                    <select class="form-select">
                                        <option>Administrador</option>
                                        <option>Residente</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Estado</label>
                                    <select class="form-select">
                                        <option>Activo</option>
                                        <option>Inactivo</option>
                                    </select>
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
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="modalEditarLabel">Editar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" value="Edcelth Jimenez">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" value="juan.perez@campoverde.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rol</label>
                                    <select class="form-select">
                                        <option selected>Administrador</option>
                                        <option>Residente</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Estado</label>
                                    <select class="form-select">
                                        <option selected>Activo</option>
                                        <option>Inactivo</option>
                                    </select>
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
</body>
</html>
<?php