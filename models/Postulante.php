<?php
require_once __DIR__ . '/../config/db.php';

class Postulante {
    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function postular($oferta_id, $nombre, $correo) {
        $sql = "INSERT INTO postulaciones (oferta_id, nombre_candidato, correo) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$oferta_id, $nombre, $correo]);
        return $this->db->lastInsertId();
    }

    public function verEstado($id) {
        $sql = "SELECT estado, comentarios, created_at FROM postulaciones WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cambiarEstado($id, $estado, $comentario) {
        $sql = "UPDATE postulaciones SET estado = ?, comentarios = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$estado, $comentario, $id]);
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM postulaciones";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorOferta($oferta_id) {
        $sql = "SELECT * FROM postulaciones WHERE oferta_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$oferta_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
