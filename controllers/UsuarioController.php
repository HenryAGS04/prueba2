<?php
include_once 'config/Database.php';
include_once 'models/Usuario.php';

class UsuarioController {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->nombre_usuario) && !empty($data->email) && !empty($data->contrasena)) {

            // Asignar propiedades al modelo
            $this->usuario->nombre_usuario = $data->nombre_usuario;
            $this->usuario->email = $data->email;
            $this->usuario->contrasena = $data->contrasena;

            // Validar si el usuario ya existe
            if ($this->usuario->exists()) {
                echo json_encode(["message" => "El nombre de usuario o correo ya está en uso."]);
                return;
            }

            // Crear usuario
            if ($this->usuario->create()) {
                echo json_encode(["message" => "Usuario registrado exitosamente."]);
            } else {
                echo json_encode(["message" => "No se pudo registrar el usuario."]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos."]);
        }
    }
}

// Manejar la solicitud POST para crear un usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsuarioController();
    $controller->create();
}
?>
