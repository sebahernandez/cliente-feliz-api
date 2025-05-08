<?php
require_once __DIR__ . '/../controllers/OfertaController.php';
require_once __DIR__ . '/../controllers/PostulanteController.php';

$uri = $_SERVER['REQUEST_URI'];

if (str_contains($uri, 'postulantes')) {
    $controller = new PostulanteController();
} else {
    $controller = new OfertaController();
}

$controller->manejarSolicitud();
?>