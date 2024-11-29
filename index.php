<?php
// Punto de entrada para la API RESTful

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        // Lógica con switch-case para manejar múltiples acciones
        switch ($action) {
            case 'login':
                require 'controllers/LoginController.php';
                break;
				
            case 'register':
                require 'controllers/RegisterController.php';
                break;				

           /* case 'xyz':
                require 'controllers/RegisterController.php';
                break;*/

            default:
                echo json_encode(["message" => "Acción no reconocida"]);
                http_response_code(400); // Bad Request
                break;
        }
    } else {
        echo json_encode(["message" => "No se especificó una acción"]);
        http_response_code(400); // Bad Request
    }
} else {
    echo json_encode(["message" => "Método no permitido"]);
    http_response_code(405); // Method Not Allowed
    // Redirigir al homepage si el método no es POST
    header("Location: /20241128_AplicacionWeb_Ejemplo_Registro_y_Login/homepage.html");
    exit();
}
?>


