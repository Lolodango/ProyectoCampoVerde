<?php
$host = '127.0.0.1';
$port = '3306';       // cámbielo a 3307 si movió MySQL
$db   = 'ProyectoResidencial';
$user = 'root';
$pass = '';           // en XAMPP root no tiene clave

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // Mensaje controlado para el usuario
    echo "Error al conectar con la base de datos.";
    // Y log para debug (puede ser a archivo en prod)
    error_log($e->getMessage());
    exit;
}