<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end px-4">
        <div class="dropdown">
            <a class="btn btn-outline-success dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Ajustes</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
            </ul>
        </div>
    </nav>
</header>