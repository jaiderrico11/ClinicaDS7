<?php
require("../../includes/Database.php");
require("../../includes/Usuarios.php");
require("../../includes/Medicos.php");

$database = new Database();
$db = $database->getConnection();

$usuarios = new Usuarios($db);
$medicos = new Medicos($db);
$message = "";

// Verificamos si se ha recibido el ID del médico a eliminar
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Eliminamos el médico de la tabla medicos
    if ($medicos->eliminar_medico($usuario_id)) {
        // Asignamos el ID del usuario a eliminar
        $usuarios->usuario_id = $usuario_id;

        // También eliminamos el usuario de la tabla usuarios
        if ($usuarios->eliminar_usuarios()) {
            $message = "Médico y usuario eliminados correctamente.";
        } else {
            $message = "El médico fue eliminado, pero no se pudo eliminar el usuario.";
        }
    } else {
        $message = "Error al eliminar el médico.";
    }

    // Redirigimos a la lista de médicos con un mensaje de confirmación
    header("Location: ../listas/lista_medicos.php?message=" . urlencode($message));
    exit();
} else {
    // Si no se recibe el ID, redirigimos a la lista de médicos
    header("Location: ../listas/lista_medicos.php");
    exit();
}
?>
