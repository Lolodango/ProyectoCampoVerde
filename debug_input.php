<?php
header('Content-Type: application/json');
echo json_encode([
  'CONTENT_TYPE' => $_SERVER['CONTENT_TYPE'] ?? null,
  'RAW'  => file_get_contents('php://input'),
  'POST' => $_POST,
], JSON_PRETTY_PRINT);
