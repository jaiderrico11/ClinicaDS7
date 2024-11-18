<?php
include "../includes/Database.php";
include "../includes/Medicos.php";

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

$medico = new Medicos($db);

// Asignar los datos del formulario
$medico->usuario_id = $_POST['usuario_id'];
$medico->especialidad = $_POST['especialidad'];
$medico->no_licencia_medica = $_POST['no_licencia_medica'];
$medico->anio_experiencia = $_POST['anio_experiencia'];
$medico->institucion = $_POST['institucion'];

// Registrar médico en la base de datos
if ($medico->registrar_medico()) {
    $resultado = "Médico registrado con éxito.";
} else {
    $resultado = "Error al registrar el médico.";
}

?>

<?php require("../template/header.php"); ?>

<section class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="text-center border p-5">
            <?php echo htmlspecialchars($resultado); ?>
            <p class="mt-3">Redirigiendo en 5 segundos a la lista de médicos...</p>
        </div>
    </div>
</section>

<!-- Script para redirigir después de 5 segundos -->
<script>
    setTimeout(function() {
        window.location.href = "../views/listas/lista_medicos.php";
    }, 5000);
</script>

<?php require("../template/footer.php"); ?>
