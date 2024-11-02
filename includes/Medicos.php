<?php

class Medicos
{
    private $conn; // Conexión a la base de datos
    private $table_name = "medicos"; // Nombre de la tabla

    // Propiedades de la clase
    public $medico_id;
    public $usuario_id;
    public $especialidad;
    public $no_licencia_medica;
    public $anio_experiencia;
    public $institucion;
    public $fecha_registro;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para registrar un nuevo médico
    public function registrar_medico()
    {
        $query = "INSERT INTO medicos (usuario_id, especialidad, no_licencia_medica, anio_experiencia, institucion, fecha_registro) 
              VALUES (:usuario_id, :especialidad, :no_licencia_medica, :anio_experiencia, :institucion, NOW())";

        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $this->usuario_id = htmlspecialchars(strip_tags($this->usuario_id));
        $this->especialidad = htmlspecialchars(strip_tags($this->especialidad));
        $this->no_licencia_medica = htmlspecialchars(strip_tags($this->no_licencia_medica));
        $this->anio_experiencia = htmlspecialchars(strip_tags($this->anio_experiencia));
        $this->institucion = htmlspecialchars(strip_tags($this->institucion));

        // Vincular parámetros
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':especialidad', $this->especialidad);
        $stmt->bindParam(':no_licencia_medica', $this->no_licencia_medica);
        $stmt->bindParam(':anio_experiencia', $this->anio_experiencia);
        $stmt->bindParam(':institucion', $this->institucion);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    // Método para consultar la lista de médicos
    public function consultar_medicos()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
    public function consultar_medico_por_usuario_id($usuario_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":usuario_id", $usuario_id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    public function consultar_medico_por_servicio_id($servicio_id)
    {
        $query = "SELECT medicos.medico_id, usuarios.nombre FROM " . $this->table_name . " JOIN usuarios ON usuarios.usuario_id = medicos.usuario_id WHERE medicos.especialidad LIKE :servicio_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":servicio_id", $servicio_id);

        if ($stmt->execute()) {
            return $stmt;
        }
        return false;
    }
    public function obtener_medico_por_id($usuario_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $usuario_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar médico
    public function actualizar_medico($usuario_id, $especialidad, $no_licencia_medica, $anio_experiencia, $institucion)
    {
        $query = "UPDATE " . $this->table_name . " 
                SET especialidad = :especialidad, no_licencia_medica = :no_licencia_medica, anio_experiencia = :anio_experiencia, institucion = :institucion
                WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);

        // Bind de los parámetros
        $stmt->bindParam(':especialidad', $especialidad);
        $stmt->bindParam(':no_licencia_medica', $no_licencia_medica);
        $stmt->bindParam(':anio_experiencia', $anio_experiencia);
        $stmt->bindParam(':institucion', $institucion);
        $stmt->bindParam(':usuario_id', $usuario_id);

        return $stmt->execute();
    }

    // Eliminar médico
    public function eliminar_medico($usuario_id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $usuario_id);
        return $stmt->execute();
    }

    public function consultar_pacientes()
    {
        $query = "SELECT DISTINCT 
                    pacientes.cedula AS Cedula,
                    usuarios.nombre AS Paciente,
                    pacientes.fecha_nacimiento AS Fecha_Nacimiento,
                    pacientes.genero AS Genero,
                    pacientes.telefono AS Telefono,
                    pacientes.direccion AS Direccion 
                    FROM citas 
                    LEFT JOIN pacientes ON pacientes.paciente_id = citas.paciente_id
                    LEFT JOIN usuarios ON usuarios.usuario_id = pacientes.usuario_id
                    WHERE citas.medico_id = :medico_id" ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':medico_id',$this->medico_id);
        $stmt->execute();
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function consultar_medicos_disponibles() {
        // Asegúrate de cambiar los nombres de las columnas y tablas según tu esquema
        $query = "SELECT m.medico_id, u.nombre 
                  FROM medicos m
                  JOIN usuarios u ON m.usuario_id = u.usuario_id"; // Asegúrate de que 'usuario_id' es la clave que relaciona ambas tablas
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
