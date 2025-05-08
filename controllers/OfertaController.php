<?php
require_once __DIR__ . '/../models/Oferta.php';

class OfertaController {
    private $model;

    public function __construct() {
        $this->model = new Oferta();
    }

    public function manejarSolicitud() {
        header("Content-Type: application/json");
        $metodo = $_SERVER['REQUEST_METHOD'];
        $datos = json_decode(file_get_contents("php://input"), true);

        switch ($metodo) {
            case 'GET':
                $this->obtener();
                break;
            case 'POST':
                $this->crear($datos);
                break;
            case 'PUT':
                $this->actualizar($datos);
                break;
            case 'PATCH':
                $this->desactivar($datos);
                break;
            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
        }
    }

    private function obtener() {
        echo json_encode($this->model->obtenerTodas());
    }

    private function crear($datos) {
        if (!isset($datos['titulo'])) {
            http_response_code(400);
            echo json_encode(["error" => "El título es obligatorio"]);
            return;
        }
        $id = $this->model->crear($datos['titulo'], $datos['descripcion'] ?? '');
        echo json_encode(["message" => "Oferta creada", "id" => $id]);
    }

    private function actualizar($datos) {
        if (!isset($datos['id'], $datos['titulo'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID y título requeridos"]);
            return;
        }
        $this->model->actualizar($datos['id'], $datos['titulo'], $datos['descripcion'] ?? '');
        echo json_encode(["message" => "Oferta actualizada"]);
    }

    private function desactivar($datos) {
        if (!isset($datos['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID requerido"]);
            return;
        }
        $this->model->desactivar($datos['id']);
        echo json_encode(["message" => "Oferta desactivada"]);
    }
}
