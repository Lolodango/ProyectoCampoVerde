<?php
require_once 'app/models/User.php';

class AuthController {
    public function login() {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $user = new User();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($user->login($username, $password)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error con el usuario, verifique su usuario y contraseña']);
        }
    }

}
