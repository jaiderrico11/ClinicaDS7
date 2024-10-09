<?php
// Incluir archivos de conexión y clase Usuario
include '../includes/Database.php';
include '../includes/Usuarios.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Obtener el ID del usuario de la URL
$usuario_id = isset($_GET['usuario_id']) ? (int)$_GET['usuario_id'] : 0;

// Validar que el ID no sea 0
if ($usuario_id <= 0) {
    echo "ID no válido.";
    exit;
}

// Consulta para obtener los datos actuales del usuario
$sql = "SELECT * FROM Usuarios WHERE usuario_id = :usuario_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}
