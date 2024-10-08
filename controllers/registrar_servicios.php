<?php
include "../includes/Database.php";
include "../includes/Servicios_Medicos.php";

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

$servicios_medicos = new Servicios_Medicos($db);

$servicios_medicos->nombre_servicio = $_POST['nombre'];
$servicios_medicos->descripcion = $_POST['descripcion'];

// Registrar el servicio médico
if ($servicios_medicos->registrar_servicio()) {
    $resultado = "Servicio Médico registrado exitosamente.";
} else {
    $resultado = "Error al registrar el Servicio Médico.";
}
?>
<?php require("../template/header.php"); ?>

<section class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="text-center border p-5">
            <?php echo $resultado; ?>
            <p class="mt-3">Redirigiendo en 5 segundos a servicios médicos</p>
        </div>
    </div>
</section>

<!-- Script para redirigir después de 5 segundos -->
<script>
    setTimeout(function() {
        window.location.href = "../views/servicios_medicos.php";
    }, 5000);
</script>
<?php require("../template/footer.php"); ?>