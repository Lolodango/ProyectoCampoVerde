<aside>
    <nav class="bg-success text-white p-3 min-vh-100" style="width: 250px;">
        <h4 class="mb-4 text-center">Campo Verde</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="dashboard.php" class="nav-link text-white activo">🏠 Dashboard</a></li>
            <li class="nav-item"><a href="noticias.php" class="nav-link text-white">📰 Noticias</a></li>
            <li class="nav-item"><a href="pagos.php" class="nav-link text-white">💵 Pagos</a></li>
            <li class="nav-item"><a href="quejas.php" class="nav-link text-white">📣 Mis Quejas</a></li>
            <li class="nav-item"><a href="reportes.php" class="nav-link text-white">📣 Mis Reportes</a></li>
            <li class="nav-item"><a href="notificaciones.php" class="nav-link text-white">🔔 Notificaciones</a></li>

            <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] === 'Administrador'): ?>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="collapse" href="#adminMenu" role="button" aria-expanded="false" aria-controls="adminMenu">
                    ⚙️ Administrador
                </a>
                <div class="collapse" id="adminMenu">
                    <ul class="nav flex-column ms-3 mt-2">
                        <li class="nav-item"><a href="usuarios.php" class="nav-link text-white">👤 Gestión de Usuarios</a></li>
                        <li class="nav-item"><a href="quejas_admin.php" class="nav-link text-white">📣 Ver Quejas</a></li>
                        <li class="nav-item"><a href="reportes_admin.php" class="nav-link text-white">📋 Ver Reportes</a></li>
                        <li class="nav-item"><a href="pagos_admin.php" class="nav-link text-white">🧍‍♂️💵 Pagos Usuarios</a></li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>

        </ul>
    </nav>
</aside>
