<?php
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/QuejaController.php';
require_once 'app/controllers/AdminQuejaController.php';

$action = $_GET['action'] ?? '';

$authController   = new AuthController();
$quejaController  = new QuejaController();
$adminQController = new AdminQuejaController();

switch ($action) {
    case 'login':                   $authController->login(); break;

    // USUARIO (quejas)
    case 'quejas_listar':           $quejaController->listar();   break;
    case 'quejas_crear':            $quejaController->crear();    break;
    case 'quejas_eliminar':         $quejaController->eliminar(); break;

    // ADMIN (quejas)
    case 'quejas_admin_listar':     $adminQController->listar();  break;
    case 'quejas_admin_estado':     $adminQController->estado();  break;
    case 'quejas_admin_eliminar':   $adminQController->eliminar();break;

    default:
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status'=>'error','message'=>'Acción no válida']);
        break;
}


