<?php
include "../includes/Database.php";
include "../includes/Citas.php";

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

$citas = new Citas($db);

$citas->cita_id = $_POST["cita_id"];
$citas->medico_id = $_POST["medico"];
$citas->hora = $_POST["hora"];

// Procesar cita
if ($citas->procesar_cita()) {
    $resultado = "Cita procesada con éxito.";
} else {
    $resultado = "Error al procesar cita médica.";
}

?>

<?php require("../template/header.php"); ?>

<section class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="text-center border p-5">
            <?php echo htmlspecialchars($resultado); ?>
            <p class="mt-3">Redirigiendo en 5 segundos a inicio...</p>
        </div>
    </div>
</section>

<!-- Script para redirigir después de 5 segundos -->
<script>
    setTimeout(function() {
        window.location.href = "../views/listas/gestion_citas.php";
    }, 5000);
</script>

<?php require("../template/footer.php"); ?>