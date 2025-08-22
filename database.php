<?php
// app/core/Database.php
class Database {
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct() {
        $host = '127.0.0.1';
        $port = '3306';
        $db   = 'ProyectoResidencial';
        $user = 'campoverde';
        $pass = 'ClaveSegura2025!';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function getInstance(): Database {
        if (!self::$instance) self::$instance = new Database();
        return self::$instance;
    }

    public function pdo(): PDO {
        return $this->pdo;
    }
}

require_once __DIR__ . '/database.php';
$db = Database::getInstance()->pdo();
