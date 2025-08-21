<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Vaci a los datos de la sesion
$_SESSION = [];

// Borra la cookie de sesion
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $p['path'],
        $p['domain'],
        $p['secure'],
        $p['httponly']
    );
}

// destruye la sesion 
session_destroy();

//borra cache
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');


header('Location: index.php');
exit;
