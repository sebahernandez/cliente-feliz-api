<?php
require_once __DIR__ . '/../models/Postulante.php';

class PostulanteController {
    private $model;

    public function __construct() {
        $this->model = new Postulante();
    }

    public function manejarSolicitud() {
        header("Content-Type: application/json");
        $metodo = $_SERVER['REQUEST_METHOD'];
        $datos = json_decode(file_get_contents("php://input"), true);

        $uri = $_SERVER['REQUEST_URI'];

        if ($metodo === 'POST') {
            $this->postular($datos);
        } elseif ($metodo === 'GET') {
            if (isset($_GET['id'])) {
                $this->verEstado($_GET['id']);
            } elseif (isset($_GET['oferta_id'])) {
                $this->listarPorOferta($_GET['oferta_id']);
            } else {
                $this->listarTodos();
            }
        } elseif ($metodo === 'PATCH') {
            $this->cambiarEstado($datos);
        } else {
            echo json_encode(["error" => "Ruta o método no permitido"]);
        }
    }

    private function postular($datos) {
        if (!isset($datos['oferta_id'], $datos['nombre_candidato'], $datos['correo'])) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos para postular"]);
            return;
        }

        $id = $this->model->postular($datos['oferta_id'], $datos['nombre_candidato'], $datos['correo']);
        echo json_encode(["message" => "Postulación registrada", "id" => $id]);
    }

    private function verEstado($id) {
        $resultado = $this->model->verEstado($id);
        if ($resultado) {
            echo json_encode($resultado);
        } else {
            echo json_encode(["error" => "Postulación no encontrada"]);
        }
    }

    private function cambiarEstado($datos) {
        if (!isset($datos['id'], $datos['estado'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID y nuevo estado requeridos"]);
            return;
        }
        $this->model->cambiarEstado($datos['id'], $datos['estado'], $datos['comentario'] ?? '');
        echo json_encode(["message" => "Estado actualizado"]);
    }

    private function listarTodos() {
        $postulantes = $this->model->obtenerTodos();
        echo json_encode($postulantes);
    }

    private function listarPorOferta($oferta_id) {
        $postulantes = $this->model->obtenerPorOferta($oferta_id);
        echo json_encode($postulantes);
    }
}
