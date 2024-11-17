<?php
include "../includes/Database.php";

// Obtener el ID del medicamento desde la solicitud
if (isset($_GET['medicamento_id'])) {
    $medicamento_id = $_GET['medicamento_id'];
    
    // Establecer la conexión con la base de datos
    $database = new Database();
    $db = $database->getConnection();
    
    // Consulta para obtener el tratamiento del medicamento
    $query = "SELECT tratamiento FROM medicamentos WHERE medicamento_id = :medicamento_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':medicamento_id', $medicamento_id, PDO::PARAM_INT);
    
    // Ejecutar la consulta y devolver el tratamiento
    if ($stmt->execute()) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            // Responder con el tratamiento en formato JSON
            echo json_encode(['tratamiento' => $data['tratamiento']]);
        } else {
            echo json_encode(['tratamiento' => '']);
        }
    } else {
        echo json_encode(['tratamiento' => '']);
    }
} else {
    echo json_encode(['tratamiento' => '']);
}
