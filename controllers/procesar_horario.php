<?php
include "../includes/Database.php";
session_start();

try {
    // Crear una instancia de la clase Database y obtener la conexión
    $database = new Database();
    $db = $database->getConnection();

    $stmt = $db->prepare("INSERT INTO horario (dia, id_medico, id_turno) VALUES(:dia, :id_medico, :turno)");
    $stmt->bindParam(':dia', $_POST["dia"]);
    $stmt->bindParam(':id_medico', $_SESSION["usuario_id"]);
    $stmt->bindParam(':turno', $_POST["turno"]);

    // Registrar el servicio médico
    if ($stmt->execute()) {
        $resultado = "Horario registrado exitosamente.";
    } else {
        $resultado = "Error al registrar el Horario.";
    }
} catch (\Throwable $th) {
    $resultado = "En ese dia ya ha sido registrado ese turno";
}

?>

<?php require("../template/header.php"); ?>

<section class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="text-center border p-5">
            <?php echo $resultado; ?>
            <p class="mt-3">Redirigiendo en 5 segundos a la pagina de inicio</p>
        </div>
    </div>
</section>

<!-- Script para redirigir después de 5 segundos -->
<script>
    setTimeout(function() {
        window.location.href = "../views/inicio/medico_inicio.php";
    }, 5000);
</script>

<?php require("../template/footer.php"); ?>