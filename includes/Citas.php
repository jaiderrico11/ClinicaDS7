<?php

class Citas
{
    private $conn; // Conexión a la base de datos
    private $table_name = "citas"; // Nombre de la tabla

    // Propiedades de la clase
    public $cita_id;
    public $fecha;
    public $hora;
    public $estado;
    public $medico_id;
    public $paciente_id;
    public $servicio_id;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function consultar_citas()
    {
        $query = "Call ConsultarCitas()";

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function solicitar_cita()
    {
        $query = "INSERT INTO " . $this->table_name . " (estado,paciente_id, servicio_id) 
              VALUES ('No Agendada', :paciente_id, :servicio_id)";

        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $this->paciente_id = htmlspecialchars(strip_tags($this->paciente_id));
        $this->servicio_id = htmlspecialchars(strip_tags($this->servicio_id));

        // Vincular parámetros
        $stmt->bindParam(':paciente_id', $this->paciente_id);
        $stmt->bindParam(':servicio_id', $this->servicio_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function procesar_cita() {
        $query = "UPDATE " . $this->table_name . " 
                SET fecha = :fecha, hora = :hora, estado = 'Agendado', medico_id = :medico_id
                WHERE cita_id = :cita_id";
        $stmt = $this->conn->prepare($query);

        // Bind de los parámetros
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':hora', $this->hora);
        $stmt->bindParam(':medico_id', $this->medico_id);
        $stmt->bindParam(':cita_id', $this->cita_id);

        return $stmt->execute();
    }

    public function consultar_citas_del_dia()
    {
        $query = "Call Consultar_Citas_Del_Dia(:medico_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':medico_id', $this->medico_id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener los resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }

    public function consultar_proximas_citas()
    {
        $query = "Call Consultar_Proximas_Citas(:medico_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':medico_id', $this->medico_id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener los resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }

    public function cancelar_cita() {}

    // Ejemplo de función
    public function consultar_paciente_por_id($paciente_id) {
        $query = "
            SELECT p.*, u.nombre 
            FROM pacientes p
            JOIN usuarios u ON p.usuario_id = u.usuario_id 
            WHERE p.paciente_id = :paciente_id
        "; 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function obtener_paciente_id_por_usuario($usuario_id) {
        $query = "SELECT paciente_id FROM pacientes WHERE usuario_id = :usuario_id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
    
        return $stmt->fetchColumn(); // Devuelve el paciente_id o false si no se encuentra
    }
    // Método para consultar citas atendidas por paciente
    public function consultar_citas_atendidas_por_paciente($paciente_id) {
        $query = "SELECT c.cita_id, c.fecha, c.hora, s.costo 
                  FROM citas c 
                  INNER JOIN servicios_medicos s ON c.servicio_id = s.servicio_id 
                  WHERE c.paciente_id = :paciente_id AND c.estado = 'Atendido'";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizar_estado_cita($cita_id, $nuevo_estado) {
        $query = "UPDATE citas SET estado = ? WHERE cita_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $nuevo_estado, $cita_id);
    
        return $stmt->execute(); // Devuelve verdadero si se actualizó correctamente
    }    
}
