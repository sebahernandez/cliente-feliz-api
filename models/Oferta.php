<?php
require_once __DIR__ . '/../config/db.php';

class Oferta {
    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function obtenerTodas() {
        $stmt = $this->db->query("SELECT * FROM ofertas WHERE activa = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($titulo, $descripcion) {
        $stmt = $this->db->prepare("INSERT INTO ofertas (titulo, descripcion) VALUES (?, ?)");
        $stmt->execute([$titulo, $descripcion]);
        return $this->db->lastInsertId();
    }

    public function actualizar($id, $titulo, $descripcion) {
        $stmt = $this->db->prepare("UPDATE ofertas SET titulo = ?, descripcion = ? WHERE id = ?");
        $stmt->execute([$titulo, $descripcion, $id]);
    }

    public function desactivar($id) {
        $stmt = $this->db->prepare("UPDATE ofertas SET activa = 0 WHERE id = ?");
        $stmt->execute([$id]);
    }
}
