<?php
require_once "../includes/Database.php";

if (isset($_POST["id_turno"])) {
    // Crear una instancia de la clase Database y obtener la conexión
    $database = new Database();
    $db = $database->getConnection();
    // Obtener las horas disponibles del medico
    $query = $db->prepare("CALL ConsultarHorasDisponibles(:id_medico, :id_turno)");
    $query->bindParam(':id_medico', $_POST["medico_id"], PDO::PARAM_INT);
    $query->bindParam(':id_turno', $_POST["id_turno"], PDO::PARAM_INT);
    $query->execute();
    $stmt = $query;
    $turno = ($_POST["id_turno"] == 1) ? 'am' : (($_POST["id_turno"] == 2) ? 'pm' : '');

    if ($stmt->rowCount() > 0) {
        echo '<option value="">Seleccione una hora</option>';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['id_hora'] . "'>" . htmlspecialchars($row['hora']) . " " . $turno . "</option>";
        }
    }else{
        echo '<option value="">No hay horas disponibles</option>';
    }
} else {
    echo '<p>No se ha seleccionado ninguna hora.</p>';
}
