<?php
require_once 'app/models/Queja.php';

class QuejaController {
    public function listar() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['usuario'])) { http_response_code(401); exit; }

        header('Content-Type: application/json; charset=utf-8');

        $numeroCasa = $_SESSION['numero_casa'] ?? '';
        $estado = isset($_GET['estado']) ? trim($_GET['estado']) : null;
        $q = new Queja();

        $res = $q->getByCasa($numeroCasa, $estado ?: null);
        if ($res === false) { echo json_encode([]); return; }

        $rows = [];
        while ($row = $res->fetch_assoc()) $rows[] = $row;
        echo json_encode($rows);
    }

    public function crear() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['usuario'])) { http_response_code(401); exit; }

        header('Content-Type: application/json; charset=utf-8');

        $titulo = trim($_POST['titulo'] ?? '');
        $desc   = trim($_POST['descripcion'] ?? '');
        if ($titulo === '' || $desc === '') {
            echo json_encode(['ok'=>false,'msg'=>'Complete título y descripción']);
            return;
        }

        $numeroCasa = $_SESSION['numero_casa'] ?? '';
        $q = new Queja();
        $ok = $q->create($titulo, $desc, $numeroCasa);
        echo json_encode(['ok'=>$ok]);
    }

    //Permite borrar su propia queja 
    public function eliminar() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['usuario'])) { http_response_code(401); exit; }

        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_POST['id_queja'] ?? 0);
        $numeroCasa = $_SESSION['numero_casa'] ?? '';
        $q = new Queja();
        $ok = $q->deleteOwned($id, $numeroCasa);
        echo json_encode(['ok'=>$ok]);
    }
}
