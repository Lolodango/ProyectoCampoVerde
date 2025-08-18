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
    <title>Noticias - Campo Verde</title>
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
                    <h3 class="text-success mb-4">Noticias Recientes</h3>
                    <div class="row g-4">
                        <!-- Noticia 1 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <img src="images/noticia1.jpg" class="card-img-top" alt="Noticia 1" />
                                <div class="card-body">
                                    <h5 class="card-title">Nueva reglamentación de seguridad</h5>
                                    <p class="card-text">Desde el 15 de agosto, se implementarán nuevas medidas de control en el ingreso...</p>
                                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalNoticia1">Leer más</button>
                                </div>
                            </div>
                        </div>

                        <!-- Noticia 2 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <img src="images/noticia2.jpg" class="card-img-top" alt="Noticia 2" />
                                <div class="card-body">
                                    <h5 class="card-title">Actividad comunitaria este fin de semana</h5>
                                    <p class="card-text">Únete a la jornada de limpieza y siembra en nuestro parque central este sábado...</p>
                                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalNoticia2">Leer más</button>
                                </div>
                            </div>
                        </div>

                        <!-- Noticia 3 -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <img src="images/noticia3.jpg" class="card-img-top" alt="Noticia 3" />
                                <div class="card-body">
                                    <h5 class="card-title">Mantenimiento de cámaras de seguridad</h5>
                                    <p class="card-text">Durante esta semana se llevará a cabo una revisión técnica de todas las cámaras...</p>
                                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalNoticia3">Leer más</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Modales de Noticias -->
                <div class="modal fade" id="modalNoticia1" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">Nueva reglamentación de seguridad</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    A partir del 15 de agosto, se aplicarán nuevas reglas de acceso al residencial Campo Verde. Cada residente
                                    deberá portar su tarjeta magnética y se instalarán nuevos lectores de huella en los accesos principales.
                                    También se restringirá el ingreso de visitas después de las 10:00 p.m. sin autorización previa.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalNoticia2" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">Actividad comunitaria</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Invitamos a todos los vecinos a unirse a la jornada de limpieza y siembra de árboles que realizaremos en
                                    el parque central este sábado a partir de las 8:00 a.m. Habrá refrigerio para los participantes y
                                    actividades para niños. ¡Participa y haz tu comunidad más verde!
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalNoticia3" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">Mantenimiento de cámaras de seguridad</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Durante esta semana, personal técnico estará revisando todas las cámaras del residencial para garantizar su
                                    correcto funcionamiento. Esto puede generar interrupciones momentáneas en algunas áreas. Agradecemos su
                                    comprensión y colaboración mientras realizamos estas mejoras.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <?php include 'components/footer.html'; ?>
</body>
</html>
