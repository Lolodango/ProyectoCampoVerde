<?php
require_once __DIR__ . '/database.php';
try {
  $pdo = Database::getInstance()->pdo();
  echo "OK conectado<br>";
  print_r($pdo->query("SHOW TABLES")->fetchAll());
} catch (Throwable $e) { echo $e->getMessage(); }
