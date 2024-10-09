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
        $query = "INSERT INTO " . $this->table_name . " (nombre, cedula, fecha_nacimiento, genero, telefono, email, direccion, contrasena) VALUES(:nombre, :cedula, :fecha_nacimiento, :genero, :telefono, :email, :direccion, :contrasena)";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->cedula = htmlspecialchars(strip_tags($this->cedula));
        $this->fecha_nacimiento = htmlspecialchars(strip_tags($this->fecha_nacimiento));
        $this->genero = htmlspecialchars(strip_tags($this->genero));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->contrasena = htmlspecialchars(strip_tags($this->contrasena));
        

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":cedula", $this->cedula);
        $stmt->bindParam(":fecha_nacimiento", $this->fecha_nacimiento);
        $stmt->bindParam(":genero", $this->genero);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":contrasena", $this->contrasena);

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
}
