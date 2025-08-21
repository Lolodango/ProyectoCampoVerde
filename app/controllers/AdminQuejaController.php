<?php
require_once 'app/models/Queja.php';

class AdminQuejaController {
    private function requireAdmin() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'Administrador') {
            http_response_code(403);
            exit;
        }
    }

    public function listar() {
        $this->requireAdmin();
        header('Content-Type: application/json; charset=utf-8');

        $estado = isset($_GET['estado']) ? trim($_GET['estado']) : null;
        $q = new Queja();

        $res = $q->getAll($estado ?: null);
        if ($res === false) { echo json_encode([]); return; }

        $rows = [];
        while ($row = $res->fetch_assoc()) $rows[] = $row;
        echo json_encode($rows);
    }

    public function estado() {
        $this->requireAdmin();
        header('Content-Type: application/json; charset=utf-8');

        $id     = (int)($_POST['id_queja'] ?? 0);
        $estado = trim($_POST['estado'] ?? '');

        $q = new Queja();
        $ok = $q->setEstado($id, $estado);
        echo json_encode(['ok'=>$ok]);
    }

    public function eliminar() {
        $this->requireAdmin();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_POST['id_queja'] ?? 0);
        $q = new Queja();
        $ok = $q->delete($id);
        echo json_encode(['ok'=>$ok]);
    }
}
