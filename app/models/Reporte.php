<?php
// app/models/Reporte.php

declare(strict_types=1);

require_once __DIR__ . '/../../database.php';

class Reporte
{
    /** @var PDO */
    private $pdo;

    public function __construct()
    {
        // Usa tu singleton Database (ya lo vienes usando en otros modelos)
        $this->pdo = Database::getInstance()->pdo();
    }

    /**
     * Crea un reporte para la cédula indicada.
     * @return int ID autoincremental del reporte creado
     */
    public function crear(string $titulo, string $descripcion, int $cedula): int
    {
        $sql = "INSERT INTO Reportes (titulo, descripcion, fecha, cedula)
                VALUES (?, ?, NOW(), ?)";
        $st = $this->pdo->prepare($sql);
        $st->execute([$titulo, $descripcion, $cedula]);
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Lista reportes de un usuario (por cédula), más recientes primero.
     * @return array<array<string,mixed>>
     */
    public function listarPorCedula(int $cedula): array
    {
        $sql = "SELECT id_reporte, titulo, descripcion, fecha, id_estado
                  FROM Reportes
                 WHERE cedula = ?
              ORDER BY fecha DESC, id_reporte DESC";
        $st = $this->pdo->prepare($sql);
        $st->execute([$cedula]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * (Opcional) Lista todos los reportes (para admin).
     * Une con Usuarios para mostrar datos básicos del autor.
     */
    public function listarTodos(): array
    {
        $sql = "SELECT r.id_reporte, r.titulo, r.descripcion, r.fecha, r.id_estado,
                       u.cedula, u.nombre, u.primer_apellido, u.nombre_usuario, u.numero_casa
                  FROM Reportes r
             LEFT JOIN Usuarios u ON u.cedula = r.cedula
              ORDER BY r.fecha DESC, r.id_reporte DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * (Opcional) Cambiar estado de un reporte.
     * Define tú el significado de estados:
     *   1 = activo/en revisión, 2 = inactivo/resuelto/eliminado (según tu catálogo)
     */
    public function cambiarEstado(int $id_reporte, int $nuevoEstado): bool
    {
        $sql = "UPDATE Reportes SET id_estado = ? WHERE id_reporte = ?";
        $st = $this->pdo->prepare($sql);
        return $st->execute([$nuevoEstado, $id_reporte]);
    }

    /**
     * Eliminación lógica: marca id_estado = 2 para ese reporte
     * (solo si pertenece a la cédula indicada).
     */
    public function eliminarLogico(int $id_reporte, int $cedula): bool
    {
        $sql = "UPDATE Reportes
                   SET id_estado = 2
                 WHERE id_reporte = ? AND cedula = ?";
        $st = $this->pdo->prepare($sql);
        return $st->execute([$id_reporte, $cedula]);
    }
}