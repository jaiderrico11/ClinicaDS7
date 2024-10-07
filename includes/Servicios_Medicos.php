<?php
class Servicios_Medicos
{
    private $conn; // Conexión a la base de datos
    private $table_name = "servicios_medicos"; // Nombre de la tabla

    // Propiedades de la clase
    public $servicio_id;
    public $nombre_servicio;
    public $descripcion;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function agregarServicios()
    {
        $query = "INSERT INTO " . $this->table_name . " (nombre_servicio, descripcion) VALUES(:nombre_servicio, :descripcion)";
        $stmt = $this->conn->prepare($query);

        $this->nombre_servicio = htmlspecialchars(strip_tags($this->nombre_servicio));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        $stmt->bindParam(":nombre_servicio", $this->nombre_servicio);
        $stmt->bindParam(":descripcion", $this->descripcion);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function consultarServicios()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nombre_servicio";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
