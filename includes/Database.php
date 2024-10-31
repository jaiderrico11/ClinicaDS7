<?php
class Database
{
    /*private $host = "201.226.33.231";
    private $db_name = "gestion_clinica";
    private $username = "root"; // Cambia a tu nombre de usuario de MySQL
    private $password = "chamoymoy"; // Cambia a tu contraseña de MySQL*/
    private $host = "localhost";
    private $db_name = "gestion_clinica";
    private $username = "root"; // Cambia a tu nombre de usuario de MySQL
    private $password = "";
    private $conn;

    // Método para obtener la conexión a la base de datos
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Modo de error de PDO
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
