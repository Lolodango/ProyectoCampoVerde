<?php
require_once 'app/config/db.php';

class User {
    private $db;
    public function __construct() { $this->db = Database::connect(); }

    public function login($username, $password) {
        $stmt = $this->db->prepare(
            "SELECT cedula, nombre_usuario, contrasena, numero_casa, id_rol
             FROM usuarios
             WHERE nombre_usuario = ?
             LIMIT 1"
        );
        if (!$stmt) return false;

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

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
