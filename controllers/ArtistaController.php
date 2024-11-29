<?php
include_once '../config/Database.php';
include_once '../models/Artista.php';

class ArtistaController {
    private $artista;

    public function __construct() {
        ini_set('display_errors', 0);
        error_reporting(E_ALL);

        $database = new Database();
        $db = $database->getConnection();
        if (!$db) {
            $this->sendResponse(500, ["message" => "Error al conectar con la base de datos."]);
        }
        $this->artista = new Artista($db);
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'POST':
                $this->createArtista();
                break;
            default:
                $this->sendResponse(405, ["message" => "Método no permitido."]);
                break;
        }
    }

    private function createArtista() {
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->Nombre) || !isset($data->Genero_Musical)) {
            $this->sendResponse(400, ["message" => "Datos incompletos."]);
            return;
        }

        $this->artista->Nombre = htmlspecialchars(strip_tags($data->Nombre));
        $this->artista->Genero_Musical = htmlspecialchars(strip_tags($data->Genero_Musical));

        if ($this->artista->create()) {
            $this->sendResponse(201, ["message" => "Artista agregado con éxito."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al agregar el artista."]);
        }
    }

    private function sendResponse($statusCode, $data) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}

// Crear instancia del controlador y manejar la solicitud
$controller = new ArtistaController();
$controller->handleRequest();
?>
