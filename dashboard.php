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
    <title>Dashboard - Campo Verde</title>
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
                <div class="container mt-4">
                    <div class="row">
                        <!-- Carousel de noticias -->
                        <div class="col-md-8 mb-4">
                            <div id="carruselNoticias" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="card">
                                            <img src="images/noticia1.jpg" class="card-img-top" alt="Seguridad">
                                            <div class="card-body">
                                                <h5 class="card-title">Nueva reglamentación de seguridad</h5>
                                                <p class="card-text">Desde el 15 de agosto se implementarán nuevas medidas de acceso. Revísalas en el boletín.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="card">
                                            <img src="images/noticia2.jpg" class="card-img-top" alt="Actividad comunitaria">
                                            <div class="card-body">
                                                <h5 class="card-title">Actividad comunitaria</h5>
                                                <p class="card-text">Este sábado habrá jornada de limpieza y siembra de árboles. ¡Participa con tu familia!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="card">
                                            <img src="images/noticia3.jpg" class="card-img-top" alt="Cámaras">
                                            <div class="card-body">
                                                <h5 class="card-title">Revisión de cámaras</h5>
                                                <p class="card-text">Esta semana se realizará mantenimiento a todas las cámaras del residencial.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carruselNoticias" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carruselNoticias" data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card border-success">
                                <div class="card-header bg-light text-success">
                                    Próximo pago pendiente
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">Cuota de mantenimiento</h6>
                                    <p class="card-text"><strong>Fecha límite:</strong> 25 de julio, 2025</p>
                                    <p class="card-text"><strong>Monto:</strong> ₡35,000</p>
                                    <a href="pagos.html" class="btn btn-outline-success w-100">Ver detalles</a>
                                </div>
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
