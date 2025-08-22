<?php
require_once __DIR__ . '/../../database.php';

class User {
    private PDO $pdo;
    private ?array $row = null;

    public function __construct() {
        $this->pdo = Database::getInstance()->pdo();
    }

    public function login(string $username, string $password): bool {
        $stmt = $this->pdo->prepare(
            'SELECT cedula, nombre_usuario, contrasena, id_rol
             FROM Usuarios WHERE nombre_usuario = ? LIMIT 1'
        );
        $stmt->execute([$username]);
        $u = $stmt->fetch();
        if (!$u) return false;

        if (!password_verify($password, $u['contrasena'])) return false;

        $this->row = $u; // <- guarda fila para getters
        return true;
    }

    public function getCedula(): ?string        { return $this->row['cedula']         ?? null; }
    public function getNombreUsuario(): ?string { return $this->row['nombre_usuario'] ?? null; }
    public function getIdRol(): ?int            { return isset($this->row['id_rol']) ? (int)$this->row['id_rol'] : null; }
}
