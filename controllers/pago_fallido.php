<?php
session_start();
require("../template/header.php");
?>

<section class="container mt-5">
    <h1 class="text-center">¡Pago Fallido!</h1>
    <div class="alert alert-danger text-center">
        <?php
        // Mostrar mensaje de error si está disponible en la sesión
        if (isset($_SESSION['mensaje_error'])) {
            echo htmlspecialchars($_SESSION['mensaje_error']);
            unset($_SESSION['mensaje_error']); // Limpiar el mensaje de error de sesión después de mostrarlo
        } else {
            echo "No se pudo procesar su pago. Por favor, intente nuevamente.";
        }
        ?>
    </div>
    <div class="text-center">
        <a href="../views/inicio_paciente.php" class="btn btn-primary">Regresar a Inicio</a>
        <a href="../views/realizar_pago.php" class="btn btn-secondary">Intentar de Nuevo</a>
    </div>
</section>

<?php require("../template/footer.php") ?>
