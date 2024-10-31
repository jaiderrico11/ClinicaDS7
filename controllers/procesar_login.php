<?php
require("../includes/Database.php");
require("../includes/Usuarios.php");
require("../includes/Pacientes.php");

session_start();

$database = new Database();
$db = $database->getConnection();

$usuarios = new Usuarios($db);
$paciente = new Pacientes($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $contrasena = htmlspecialchars(strip_tags($_POST['contrasena']));

    // Verificar credenciales
    $usuario = $usuarios->consultar_usuario_por_email($email);
    $paciente = $paciente->consultar_paciente_por_email($email);
    
    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        // Credenciales válidas
        $_SESSION['usuario_id'] = $usuario['usuario_id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        // Redirigir según el rol
        if ($usuario['rol'] == 'admin') {
            header("Location: ../views/admin_inicio.php"); // Redirigir a la pantalla de administrador
        } else if ($usuario['rol'] == 'Recursos Humanos') {
            header("Location: ../views/inicio_recursos_humanos.php");
        } else if ($usuario['rol'] == 'Recepcionista') {
            header("Location: ../views/inicio_recepcionista.php");
        } else {
            header("Location: ../views/usuario_inicio.php"); // Redirigir a la pantalla de usuario regular
        }
        exit();
    } else if ($paciente && password_verify($contrasena, $paciente['contrasena'])) {
        $_SESSION['paciente_id'] = $paciente['paciente_id'];
        header("Location: ../views/inicio_paciente.php");
        exit();
    } else {
        // Credenciales incorrectas
        $error_message = "Email o contraseña incorrectos.";
        header("Location: ../views/login.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    // Si se accede al script sin usar POST
    header("Location: ../views/login.php");
    exit();
}
