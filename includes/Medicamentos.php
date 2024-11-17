<?php
class Medicamentos {
    private $conn;
    private $table_name = "medicamentos";

    public $medicamento_id;
    public $nombre;
    public $cantidad;
    public $unidad;
    public $tipo;
    public $tratamiento;
    public $id_padecimiento;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertar_medicamento() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, cantidad, unidad, tipo, tratamiento, id_padecimiento) VALUES (:nombre, :cantidad, :unidad, :tipo, :tratamiento, :id_padecimiento)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':cantidad', $this->cantidad);
        $stmt->bindParam(':unidad', $this->unidad);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':tratamiento', $this->tratamiento);
        $stmt->bindParam(':id_padecimiento', $this->id_padecimiento);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function obtener_medicamentos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>