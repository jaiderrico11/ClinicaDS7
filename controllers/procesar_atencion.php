<?php
include "../includes/Database.php";
include "../includes/Citas.php";
session_start();

$database = new Database();
$db = $database->getConnection();

$citas = new Citas($db);

// Verificamos si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paciente_id = $_POST['paciente_id'];
    $diagnostico = $_POST['diagnostico'];
    $medicamento = $_POST['medicamento'];
    $tratamiento = $_POST['tratamiento'];

    // Primero, deberías asegurarte de que el paciente existe (opcional)
    $paciente_data = $citas->consultar_paciente_por_id($paciente_id);
    if (!$paciente_data) {
        die("El paciente no existe.");
    }

    // Crear el historial clínico
    $query_historial = "INSERT INTO historial_clinico (paciente_id, fecha_creacion) VALUES (:paciente_id, NOW())";
    $stmt_historial = $db->prepare($query_historial);
    $stmt_historial->bindParam(':paciente_id', $paciente_id);

    if ($stmt_historial->execute()) {
        $historial_id = $db->lastInsertId(); // Obtener el ID del historial creado

        // Insertar el diagnóstico en la tabla diagnósticos
        $query_diagnostico = "INSERT INTO diagnosticos (historial_id, paciente_id, descripcion, fecha_diagnostico) VALUES (:historial_id, :paciente_id, :descripcion, NOW())";
        $stmt_diagnostico = $db->prepare($query_diagnostico);
        $stmt_diagnostico->bindParam(':historial_id', $historial_id);
        $stmt_diagnostico->bindParam(':paciente_id', $paciente_id);
        $stmt_diagnostico->bindParam(':descripcion', $diagnostico);

        if ($stmt_diagnostico->execute()) {
            // Insertar receta médica
            $query_recetas = "INSERT INTO recetas (paciente_id, medicamento, tratamiento, fecha_prescripcion) VALUES (:paciente_id, :medicamento, :tratamiento, NOW())";
            $stmt_recetas = $db->prepare($query_recetas);
            $stmt_recetas->bindParam(':paciente_id', $paciente_id);
            $stmt_recetas->bindParam(':medicamento', $medicamento);
            $stmt_recetas->bindParam(':tratamiento', $tratamiento);

            // Ejecutar la inserción de la receta médica
            if ($stmt_recetas->execute()) {
                // Guardar el mensaje de éxito en la sesión
                $_SESSION['success_message'] = 'Atención registrada exitosamente.';
            } else {
                $_SESSION['error_message'] = 'Error al guardar la receta médica.';
            }
        } else {
            $_SESSION['error_message'] = 'Error al guardar el diagnóstico.';
        }
    } else {
        $_SESSION['error_message'] = 'Error al guardar el historial clínico.';
    }
    // Redirigir de vuelta al formulario
    header("Location: ../views/registrar/atender_paciente.php?paciente_id=" . $paciente_id);
    exit();
} else {
    $_SESSION['error_message'] = 'No se han enviado datos.';
    header("Location: ../views/atender_paciente.php");
    exit();
}
?>
