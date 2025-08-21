<?php
require_once __DIR__ . '/../../database.php';

class User {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->pdo();
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare(
            "SELECT cedula, nombre_usuario, contrasena, numero_casa, id_rol
             FROM usuarios
             WHERE nombre_usuario = ?
             LIMIT 1"
        );
        if (!$stmt) return false;

        $stmt->execute([$username]);
        $row = $stmt->fetch();

        if (!$row) return false;
        if (!password_verify($password, $row['contrasena'])) return false;

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_regenerate_id(true);

        $_SESSION['id_usuario']  = (int)$row['cedula'];
        $_SESSION['usuario']     = $row['nombre_usuario'];
        $_SESSION['numero_casa'] = $row['numero_casa'];
        $_SESSION['rol']         = ((int)$row['id_rol'] === 1 ? 'Administrador' : 'Usuario');

        return true;
    }
}
