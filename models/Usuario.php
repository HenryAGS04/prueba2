<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id_usuario;
    public $nombre_usuario;
    public $email;
    public $contrasena;
    public $id_rol = 2; // Rol por defecto para un nuevo usuario
    public $activo = 1;
    public $creado_el;
    public $actualizado_el;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre_usuario = :nombre_usuario, 
                      email = :email, 
                      contrasena = :contrasena, 
                      activo = :activo";

        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->nombre_usuario = htmlspecialchars(strip_tags($this->nombre_usuario));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contrasena = password_hash($this->contrasena, PASSWORD_BCRYPT);

        // Vincular parámetros
        $stmt->bindParam(":nombre_usuario", $this->nombre_usuario);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":contrasena", $this->contrasena);
        $stmt->bindParam(":activo", $this->activo);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Validar si el nombre de usuario o correo ya existe
    public function exists() {
        $query = "SELECT id_usuario FROM " . $this->table_name . " 
                  WHERE nombre_usuario = :nombre_usuario OR email = :email";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre_usuario", $this->nombre_usuario);
        $stmt->bindParam(":email", $this->email);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
	
    // Autenticar usuario
    public function login() {
        $query = "SELECT id_usuario, contrasena FROM " . $this->table_name . " 
                  WHERE email = :email OR nombre_usuario = :nombre_usuario";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre_usuario", $this->nombre_usuario);
        $stmt->bindParam(":email", $this->email);

        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->contrasena, $row['contrasena'])) {
                return true;
            }
        }

        return false;
    }	
	
}
?>
