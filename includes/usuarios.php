<?php

class Usuarios
{
    private $conn; // Conexión a la base de datos
    private $table_name = "usuarios"; // Nombre de la tabla

    // Propiedades de la clase
    public $usuario_id;
    public $nombre;
    public $email;
    public $contrasena;
    public $rol;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrar_usuarios()
    {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, contrasena, rol) VALUES(:nombre, :email, :contrasena, :rol)";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contrasena = htmlspecialchars(strip_tags($this->contrasena));
        $this->rol = htmlspecialchars(strip_tags($this->rol));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":contrasena", $this->contrasena);
        $stmt->bindParam(":rol", $this->rol);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function consultar_usuarios()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function actualizar_usuarios()
    {
        $query = "UPDATE " . $this->table_name . " 
        SET nombre = :nombre, email = :email, rol = :rol 
        WHERE usuario_id = :usuario_id";

        $stmt = $this->conn->prepare($query);

        // Enlazar parámetros
        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":rol", $this->rol);

        if ($stmt->execute()) {
            return true;
        }
    }
    public function consultar_medicos_por_rol()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE rol = 'medico'";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function eliminar_usuarios()
    {
        $sql = "DELETE FROM " . $this->table_name . " WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function consultar_usuario_por_email($email)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

}
