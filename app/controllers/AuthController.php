<?php
require_once 'app/models/User.php';

class AuthController {
    public function login() {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        header('Content-Type: application/json; charset=utf-8');

        $user = new User();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            echo json_encode(['status' => 'error', 'message' => 'Usuario y contraseña requeridos']);
            return;
        }

        if ($user->login($username, $password)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error con el usuario, verifique su usuario y contraseña']);
        }
    }

}
