<?php
class Insumos {
    private $conn;
    private $table_name = "insumos";

    public $insumo_id;
    public $nombre;
    public $cantidad;
    public $unidad;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertar_insumo() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, cantidad, unidad) VALUES (:nombre, :cantidad, :unidad)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':cantidad', $this->cantidad);
        $stmt->bindParam(':unidad', $this->unidad);
        return $stmt->execute();
    }

    public function obtener_insumos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>