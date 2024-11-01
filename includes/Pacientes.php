<?php

class Pacientes
{
    private $conn; // Conexión a la base de datos
    private $table_name = "pacientes"; // Nombre de la tabla

    // Propiedades de la clase
    public $paciente_id;
    public $nombre;
    public $cedula;
    public $fecha_nacimiento;
    public $genero;
    public $telefono;
    public $email;
    public $direccion;
    public $contrasena;


    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrar_pacientes()
    {
        $query = "CALL RegistrarPaciente(:nombre, :email, :contrasena, :cedula, :fecha_nacimiento, :genero, :telefono, :direccion)";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contrasena = htmlspecialchars(strip_tags($this->contrasena));
        $this->cedula = htmlspecialchars(strip_tags($this->cedula));
        $this->fecha_nacimiento = htmlspecialchars(strip_tags($this->fecha_nacimiento));
        $this->genero = htmlspecialchars(strip_tags($this->genero));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));


        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":contrasena", $this->contrasena);
        $stmt->bindParam(":cedula", $this->cedula);
        $stmt->bindParam(":fecha_nacimiento", $this->fecha_nacimiento);
        $stmt->bindParam(":genero", $this->genero);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":direccion", $this->direccion);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function consultar_pacientes()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function obtener_id_paciente($usuario_id)
    {
        $query = "SELECT paciente_id FROM pacientes WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":usuario_id", $usuario_id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
}
