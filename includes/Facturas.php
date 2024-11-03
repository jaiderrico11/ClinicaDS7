<?php
class Facturas {
    private $conn;

    // Constructor para inicializar la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para consultar facturas por paciente
    public function consultar_facturas_por_paciente($paciente_id) {
        $query = "SELECT factura_id, paciente_id, fecha_emision, monto, estado FROM facturas WHERE paciente_id = :paciente_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear_factura($paciente_id, $monto) {
        $fecha_emision = date('Y-m-d H:i:s'); // Fecha actual
        $estado = 'Pendiente'; // Estado inicial de la factura
    
        $query = "INSERT INTO facturas (paciente_id, fecha_emision, monto, estado) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isss", $paciente_id, $fecha_emision, $monto, $estado);
    
        if ($stmt->execute()) {
            return $this->conn->insert_id; // Devuelve el ID de la factura recién creada
        } else {
            return false; // En caso de error
        }
    }
    
   
    
}

?>
