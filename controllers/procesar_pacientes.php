<?php
include "../includes/Database.php";
include "../includes/Pacientes.php";

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

$pacientes = new Pacientes($db);

$pacientes->nombre = $_POST['nombre'];
$pacientes->cedula = $_POST['cedula'];
$pacientes->fecha_nacimiento = $_POST['fecha_nacimiento'];
$pacientes->genero = $_POST['genero'];
$pacientes->telefono = $_POST['telefono'];
$pacientes->email = $_POST['email'];
$pacientes->direccion = $_POST['direccion'];
$pacientes->contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);


// Registrar el servicio médico
if ($pacientes->registrar_pacientes()) {
    $resultado = "Paciente registrado exitosamente.";
} else {
    $resultado = "Error al registrar el paciente.";
}

?>

<?php require("../template/header.php"); ?>

<section class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="text-center border p-5">
            <?php echo $resultado; ?>
            <p class="mt-3">Redirigiendo en 5 segundos al inicio</p>
        </div>
    </div>
</section>

<!-- Script para redirigir después de 5 segundos -->
<script>
    setTimeout(function() {
        window.location.href = "../views/inicio/inicio_recepcionista.php";
    }, 5000);
</script>

<?php require("../template/footer.php"); ?>