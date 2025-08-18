<?php
require_once 'app/config/db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function login($username, $password) {
    $stmt = $this->db->prepare("SELECT U.nombre_usuario,U.contrasena,R.nombre_rol FROM Usuarios U
    JOIN Rol R ON U.id_rol = R.id_rol
    WHERE U.nombre_usuario = ?");

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['contrasena'])) {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['usuario'] = $result['nombre_usuario'];
        $_SESSION['rol'] = $result['nombre_rol'];
        return true;
    }
    return false;
}
}
