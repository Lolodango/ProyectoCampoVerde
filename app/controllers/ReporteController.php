<?php
// app/controllers/ReporteController.php
declare(strict_types=1);

require_once 'app/models/Reporte.php';

class ReporteController
{
    /** Helper: respuesta JSON uniforme */
    private function json(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    /** Helper: arranca sesión si hace falta */
    private function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /** Helper: true si el rol actual es Administrador */
    private function isAdmin(): bool
    {
        $rol = $_SESSION['rol'] ?? null;
        return ($rol === 1 || $rol === '1' || $rol === 'Administrador');
    }

    /** POST: Crea un reporte para el usuario en sesión */
    public function crear(): void
    {
        $this->startSession();

        $cedula = $_SESSION['cedula'] ?? $_SESSION['id_usuario'] ?? null;
        if (!$cedula) {
            $this->json(['status' => 'error', 'message' => 'Sesión inválida (sin cédula).'], 401);
            return;
        }

        // Datos del formulario
        $titulo      = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if ($titulo === '' || $descripcion === '') {
            $this->json(['status' => 'error', 'message' => 'Título y descripción son requeridos']); 
            return;
        }

        try {
            $m = new Reporte();
            $id = $m->crear($titulo, $descripcion, (int)$cedula);
            $this->json(['status' => 'success', 'id_reporte' => $id]);
        } catch (PDOException $e) {
            $this->json([
                'status'  => 'error',
                'message' => 'Error al guardar el reporte',
                'debug'   => $e->getMessage() // <- déjalo solo mientras depuras
            ], 500);
        }
    }

    /** GET: Lista reportes del usuario logueado */
    public function listar(): void
    {
        $this->startSession();

        $cedula = $_SESSION['cedula'] ?? $_SESSION['id_usuario'] ?? null;
        if (!$cedula) {
            $this->json(['status' => 'error', 'message' => 'Sesión inválida'], 401);
            return;
        }

        try {
            $m = new Reporte();
            $data = $m->listarPorCedula((int)$cedula);
            $this->json(['status' => 'success', 'data' => $data]);
        } catch (PDOException $e) {
            $this->json(['status' => 'error', 'message' => 'Error al listar', 'debug' => $e->getMessage()], 500);
        }
    }

    /** GET: Lista todos los reportes (solo Admin) */
    public function listar_admin(): void
    {
        $this->startSession();

        if (!$this->isAdmin()) {
            $this->json(['status' => 'error', 'message' => 'No autorizado'], 403);
            return;
        }

        try {
            $m = new Reporte();
            $data = $m->listarTodos();
            $this->json(['status' => 'success', 'data' => $data]);
        } catch (PDOException $e) {
            $this->json(['status' => 'error', 'message' => 'Error al listar', 'debug' => $e->getMessage()], 500);
        }
    }

    /** POST: Cambia el estado de un reporte (solo Admin) */
    public function estado(): void
    {
        $this->startSession();

        if (!$this->isAdmin()) {
            $this->json(['status' => 'error', 'message' => 'No autorizado'], 403);
            return;
        }

        $id_reporte  = (int)($_POST['id_reporte'] ?? 0);
        $id_estado   = (int)($_POST['id_estado'] ?? 0);

        if ($id_reporte <= 0 || $id_estado <= 0) {
            $this->json(['status' => 'error', 'message' => 'Parámetros inválidos']);
            return;
        }

        try {
            $m = new Reporte();
            $ok = $m->cambiarEstado($id_reporte, $id_estado);
            $this->json(['status' => $ok ? 'success' : 'error']);
        } catch (PDOException $e) {
            $this->json(['status' => 'error', 'message' => 'Error al actualizar estado', 'debug' => $e->getMessage()], 500);
        }
    }

    /** POST: Eliminación lógica (propietario o Admin) */
    public function eliminar(): void
    {
        $this->startSession();

        $cedulaSesion = $_SESSION['cedula'] ?? $_SESSION['id_usuario'] ?? null;
        if (!$cedulaSesion) {
            $this->json(['status' => 'error', 'message' => 'Sesión inválida'], 401);
            return;
        }

        $id_reporte = (int)($_POST['id_reporte'] ?? 0);
        if ($id_reporte <= 0) {
            $this->json(['status' => 'error', 'message' => 'ID de reporte inválido']);
            return;
        }

        try {
            $m = new Reporte();

            if ($this->isAdmin()) {
                // Admin puede eliminar lógico cualquier reporte:
                $ok = $m->cambiarEstado($id_reporte, 2);
            } else {
                // Usuario solo puede eliminar (lógico) sus propios reportes
                $ok = $m->eliminarLogico($id_reporte, (int)$cedulaSesion);
            }

            $this->json(['status' => $ok ? 'success' : 'error']);
        } catch (PDOException $e) {
            $this->json(['status' => 'error', 'message' => 'Error al eliminar', 'debug' => $e->getMessage()], 500);
        }
    }
}
