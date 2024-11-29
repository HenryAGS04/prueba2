<?php
include_once 'config/Database.php';
include_once 'models/Usuario.php';

class LoginController {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->nombre_usuario) || !empty($data->email) && !empty($data->contrasena)) {

            // Asignar propiedades al modelo
            $this->usuario->nombre_usuario = $data->nombre_usuario;
            $this->usuario->email = $data->email;
            $this->usuario->contrasena = $data->contrasena;

            // Validar credenciales
            if ($this->usuario->login()) {
                echo json_encode(["message" => "Inicio de sesión exitoso."]);
            } else {
                echo json_encode(["message" => "Nombre de usuario o contraseña incorrectos."]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos."]);
        }
    }
}

// Manejar la solicitud POST para iniciar sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new LoginController();
    $controller->login();
}
?>
