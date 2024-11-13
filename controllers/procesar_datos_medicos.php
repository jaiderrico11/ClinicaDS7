<?php
include "../includes/Database.php";
include "../includes/Datos_Medicos.php";
session_start();

$database = new Database();
$db = $database->getConnection();
$datos_medicos = new Datos_Medicos($db);

// Verificamos si el usuario está logeado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Verificar si los datos fueron enviados por el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paciente_id = $_POST['paciente_id'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $tipo_sangre = $_POST['tipo_sangre'];
    $alergias = $_POST['alergias'];

    // Validar datos (aquí podrías añadir validaciones adicionales, como verificar que sean números, etc.)
    if (empty($altura) || empty($peso) || empty($tipo_sangre) || empty($alergias)) {
        $_SESSION['error_message'] = "Todos los campos son obligatorios.";
        header("Location: ../../views/registrar/datos_medicos.php");
        exit();
    }

    // Cargar los datos médicos actuales
    $datos_medicos->paciente_id = $paciente_id;
    $datos_medicos->altura = $altura;
    $datos_medicos->peso = $peso;
    $datos_medicos->tipo_sangre = $tipo_sangre;
    $datos_medicos->alergias = $alergias;

    // Verificar si los datos médicos ya existen
    if ($datos_medicos->existe()) {
        // Si existen, actualizar los datos
        if ($datos_medicos->actualizar()) {
            $_SESSION['success_message'] = "Datos médicos actualizados correctamente.";
        } else {
            $_SESSION['error_message'] = "Error al actualizar los datos médicos.";
        }
    } else {
        // Si no existen, insertar los datos médicos
        if ($datos_medicos->insertar()) {
            $_SESSION['success_message'] = "Datos médicos registrados correctamente.";
        } else {
            $_SESSION['error_message'] = "Error al registrar los datos médicos.";
        }
    }

    // Redirigir de vuelta al formulario con el mensaje correspondiente
    header("Location: ../../views/registrar/datos_medicos.php");
    exit();
}
?>
