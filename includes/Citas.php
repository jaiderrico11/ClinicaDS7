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
        $query = "SELECT citas.cita_id,
                        pacientes.paciente_id,
                        pacientes.nombre AS Paciente,
                        servicios_medicos.nombre_servicio AS Servicio
                FROM " . $this->table_name .
            " LEFT JOIN pacientes ON pacientes.paciente_id = " . $this->table_name . ".paciente_id " .
            "LEFT JOIN servicios_medicos ON servicios_medicos.servicio_id = " . $this->table_name . ".servicio_id WHERE estado NOT LIKE 'Agendado'";

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

    public function cancelar_cita() {}
}
