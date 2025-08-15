<?php
class Database {
  public static function connect() {
    $db = @new mysqli('127.0.0.1', 'root', '', 'campoverde', 3307);
    if ($db->connect_errno) {
      http_response_code(500);
      die('Error de conexión a la BD: ' . $db->connect_error);
    }
    $db->set_charset('utf8mb4');
    return $db;
  }
}
