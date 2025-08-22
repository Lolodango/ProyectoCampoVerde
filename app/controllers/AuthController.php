<?php
require_once 'app/models/User.php';

class AuthController {
    public function login() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        header('Content-Type: application/json; charset=utf-8');

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            echo json_encode(['status'=>'error','message'=>'Usuario y contraseña requeridos']); return;
        }

        $user = new User();
        if ($user->login($username, $password)) {
            session_regenerate_id(true);
            $_SESSION['cedula']  = $user->getCedula();
            $_SESSION['usuario'] = $user->getNombreUsuario();
            $_SESSION['rol']     = $user->getIdRol();  // <-- DEBE quedar 1 para admin

            // DEBUG temporal para ver qué quedó en sesión (quitar luego)
            // file_put_contents(__DIR__.'/../../session_debug.txt', print_r($_SESSION, true));

            echo json_encode(['status'=>'success']); return;
        }

        echo json_encode(['status'=>'error','message'=>'Usuario o contraseña incorrectos']);
    }
}
