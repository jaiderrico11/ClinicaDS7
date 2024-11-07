<?php
include "../includes/Database.php";
include "../includes/Citas.php";

$database = new Database();
$db = $database->getConnection();

$citas = new Citas($db);

$mensaje = $citas->actualizar_estado_cita($_POST["cita_id"], "Cancelado");
?>

<?php require("../template/header.php"); ?>

<section class="container mt-5">
    <div class="text-center">
        <h2 class="mb-4">
            <?php echo $mensaje ? "Cancelado Exitosamente" : "Error al Cancelar"; ?>
        </h2>
        <p class="">
            <?php echo $mensaje ? "La cita ha sido cancelada exitosamente." : "Hubo un error al cancelar la cita. Por favor, intente de nuevo."; ?>
        </p>

        <div>
            <a href="../views/listas/lista_citas.php" class="btn btn-primary">Volver a lista de citas</a>
        </div>
    </div>
</section>

<?php require("../template/footer.php"); ?>