<?php
class Padecimientos {
    private $conn;
    private $table_name = "padecimiento";

    public $id_padecimiento;
    public $padecimiento;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertar_padecimiento() {
        $query = "INSERT INTO " . $this->table_name . " (padecimiento) VALUES (:padecimiento)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':padecimiento', $this->padecimiento);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function obtener_padecimientos() {
        $query = "SELECT id_padecimiento, padecimiento FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>