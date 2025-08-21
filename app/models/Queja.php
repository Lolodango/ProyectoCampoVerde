<?php
require_once 'app/config/db.php';

class Queja {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    //Lista las quejas con un filtro por estado
    public function getAll($estado = null) {
        if ($estado) {
            $stmt = $this->db->prepare(
                "SELECT id_queja, titulo, descripcion, fecha, estado, numero_casa
                 FROM Quejas
                 WHERE estado = ?
                 ORDER BY fecha DESC"
            );
            if (!$stmt) return false;
            $stmt->bind_param("s", $estado);
            $stmt->execute();
            return $stmt->get_result();
        } else {
            $sql = "SELECT id_queja, titulo, descripcion, fecha, estado, numero_casa
                    FROM Quejas
                    ORDER BY fecha DESC";
            return $this->db->query($sql); 
        }
    }

    //Lista las quejas por usuario
    public function getByCasa($numero_casa, $estado = null) {
        if ($estado) {
            $stmt = $this->db->prepare(
                "SELECT id_queja, titulo, descripcion, fecha, estado, numero_casa
                 FROM Quejas
                 WHERE numero_casa = ? AND estado = ?
                 ORDER BY fecha DESC"
            );
            if (!$stmt) return false;
            $stmt->bind_param("ss", $numero_casa, $estado);
        } else {
            $stmt = $this->db->prepare(
                "SELECT id_queja, titulo, descripcion, fecha, estado, numero_casa
                 FROM Quejas
                 WHERE numero_casa = ?
                 ORDER BY fecha DESC"
            );
            if (!$stmt) return false;
            $stmt->bind_param("s", $numero_casa);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

   
    public function getById($id_queja) {
        $stmt = $this->db->prepare(
            "SELECT id_queja, titulo, descripcion, fecha, estado, numero_casa
             FROM Quejas WHERE id_queja = ?"
        );
        if (!$stmt) return false;
        $stmt->bind_param("i", $id_queja);
        $stmt->execute();
        $res = $stmt->get_result();
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc() : null;
    }

    //CRUD basico

    public function create($titulo, $descripcion, $numero_casa) {
        $stmt = $this->db->prepare(
            "INSERT INTO Quejas (titulo, descripcion, numero_casa, estado)
             VALUES (?, ?, ?, 'pendiente')"
        );
        if (!$stmt) return false;
        $stmt->bind_param("sss", $titulo, $descripcion, $numero_casa);
        return $stmt->execute();
    }

    public function update($id_queja, $titulo, $descripcion) {
        $stmt = $this->db->prepare(
            "UPDATE Quejas SET titulo = ?, descripcion = ? WHERE id_queja = ?"
        );
        if (!$stmt) return false;
        $stmt->bind_param("ssi", $titulo, $descripcion, $id_queja);
        return $stmt->execute();
    }

    public function setEstado($id_queja, $estado) {
        $permitidos = ['pendiente','en_revision','resuelta'];
        if (!in_array($estado, $permitidos, true)) return false;

        $stmt = $this->db->prepare("UPDATE Quejas SET estado = ? WHERE id_queja = ?");
        if (!$stmt) return false;
        $stmt->bind_param("si", $estado, $id_queja);
        return $stmt->execute();
    }

    public function delete($id_queja) {
        $stmt = $this->db->prepare("DELETE FROM Quejas WHERE id_queja = ?");
        if (!$stmt) return false;
        $stmt->bind_param("i", $id_queja);
        return $stmt->execute();
    }

    public function deleteOwned($id_queja, $numero_casa) {
        $stmt = $this->db->prepare("DELETE FROM Quejas WHERE id_queja = ? AND numero_casa = ?");
        if (!$stmt) return false;
        $stmt->bind_param("is", $id_queja, $numero_casa);
        return $stmt->execute();
    }
}
