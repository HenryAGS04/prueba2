<?php
class Artista {
    private $conn;
    private $table_name = "artista";

    public $ID_Artista;
    public $Nombre;
    public $Genero_Musical;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (Nombre, Genero_Musical) VALUES (:Nombre, :Genero_Musical)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':Nombre', htmlspecialchars(strip_tags($this->Nombre)));
        $stmt->bindParam(':Genero_Musical', htmlspecialchars(strip_tags($this->Genero_Musical)));

        return $stmt->execute();
    }
}
?>
