<?php
require_once __DIR__ . '/app/config/db.php';
$db = DB::conn();

$newHash = password_hash('admin123', PASSWORD_BCRYPT);

$st = $db->prepare("UPDATE users SET password=? WHERE username='admin' LIMIT 1");
$st->bind_param('s', $newHash);
$st->execute();

echo $st->affected_rows > 0 ? "OK: admin=admin123" : "No se actualizó (¿no existe admin?)";
