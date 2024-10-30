<?php
require_once "../includes/Database.php";
require_once "../includes/Medicos.php";

if (isset($_POST['servicio_id'])) {
    // Obtener el ID de la marcas desde la solicitud AJAX
    $servicio_id = $_POST['servicio_id'];

    $database = new Database();
    $db = $database->getConnection();

    $medicos = new Medicos($db);
    $stmt = $medicos->consultar_medico_por_servicio_id($servicio_id);
    
    if ($stmt->rowCount() > 0) {
        echo '<option value="">Seleccione un médico</option>';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row['medico_id'] . '">' . htmlspecialchars($row['nombre']) . '</option>';
        }
    } else {
        echo '<option value="">No hay médicos disponibles</option>';
    }
}
