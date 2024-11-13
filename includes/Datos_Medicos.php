<?php
class Datos_Medicos {
    private $conn;
    private $table_name = "datos_medicos";

    // Propiedades
    public $paciente_id;
    public $altura;
    public $peso;
    public $tipo_sangre;
    public $alergias;

    // Constructor con la conexión de la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener los datos médicos por paciente_id
    public function obtenerPorPacienteId($paciente_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE paciente_id = :paciente_id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':paciente_id', $paciente_id);
        
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Mapear los resultados a las propiedades
            if ($row) {
                $this->paciente_id = $row['paciente_id'];
                $this->altura = $row['altura'];
                $this->peso = $row['peso'];
                $this->tipo_sangre = $row['tipo_sangre'];
                $this->alergias = $row['alergias'];
            }
            return true;
        }
        return false;
    }

    // Método para actualizar los datos médicos
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET altura = :altura, peso = :peso, tipo_sangre = :tipo_sangre, alergias = :alergias 
                  WHERE paciente_id = :paciente_id";
        
        $stmt = $this->conn->prepare($query);
        
        // Asociar los valores de las propiedades a los parámetros
        $stmt->bindParam(':altura', $this->altura);
        $stmt->bindParam(':peso', $this->peso);
        $stmt->bindParam(':tipo_sangre', $this->tipo_sangre);
        $stmt->bindParam(':alergias', $this->alergias);
        $stmt->bindParam(':paciente_id', $this->paciente_id);
        
        // Ejecutar la consulta y verificar si se actualizó correctamente
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para crear un nuevo registro de datos médicos (si es necesario)
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (paciente_id, altura, peso, tipo_sangre, alergias)
                  VALUES (:paciente_id, :altura, :peso, :tipo_sangre, :alergias)";
        
        $stmt = $this->conn->prepare($query);
        
        // Asociar los valores de las propiedades a los parámetros
        $stmt->bindParam(':paciente_id', $this->paciente_id);
        $stmt->bindParam(':altura', $this->altura);
        $stmt->bindParam(':peso', $this->peso);
        $stmt->bindParam(':tipo_sangre', $this->tipo_sangre);
        $stmt->bindParam(':alergias', $this->alergias);
        
        // Ejecutar la consulta y verificar si se creó correctamente
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function existe() {
        $query = "SELECT COUNT(*) FROM datos_medicos WHERE paciente_id = :paciente_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':paciente_id', $this->paciente_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function insertar() {
        $query = "INSERT INTO datos_medicos (paciente_id, altura, peso, tipo_sangre, alergias) 
                  VALUES (:paciente_id, :altura, :peso, :tipo_sangre, :alergias)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':paciente_id', $this->paciente_id);
        $stmt->bindParam(':altura', $this->altura);
        $stmt->bindParam(':peso', $this->peso);
        $stmt->bindParam(':tipo_sangre', $this->tipo_sangre);
        $stmt->bindParam(':alergias', $this->alergias);

        return $stmt->execute();
    }
}
?>
