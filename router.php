<?php
require_once __DIR__ . '/app/controllers/AuthController.php';
header('Cache-Control: no-store');

$auth = new AuthController();
$action = $_GET['action'] ?? '';

switch ($action) {
  case 'login':   $auth->login();   break;
  case 'logout':  $auth->logout();  break;
  case 'me':      $auth->me();      break; // opcional para guard en páginas
  default:
    header('Content-Type: application/json');
    echo json_encode(['status'=>'error','message'=>'Ruta no encontrada']);
}
