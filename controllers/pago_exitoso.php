<?php
session_start();
require("../template/header.php");
?>

<section class="container mt-5">
    <h1 class="text-center">¡Pago Exitoso!</h1>
    <div class="alert alert-success text-center">
        <?php
        // Mostrar mensaje de éxito si está disponible en la sesión
        if (isset($_SESSION['mensaje'])) {
            echo htmlspecialchars($_SESSION['mensaje']);
            unset($_SESSION['mensaje']); // Limpiar el mensaje de sesión después de mostrarlo
        } else {
            echo "Su pago se ha procesado correctamente.";
        }
        ?>
    </div>
    <div class="text-center">
        <a href="../views/inicio_paciente.php" class="btn btn-primary">Regresar a Inicio</a>
    </div>
</section>

<?php require("../template/footer.php") ?>
