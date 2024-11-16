<?php
include "../../includes/Database.php";
include "../../includes/Padecimientos.php";

$database = new Database();
$db = $database->getConnection();

$padecimientos = new Padecimientos($db);
$padecimientos->padecimiento = $_POST["padecimiento"];

$insertado = $padecimientos->insertar_padecimiento();
?>

<?php require("../template/header.php"); ?>

<section class="container mt-5">
    <div class="text-center">
        <h2 class="mb-4">
            <?php echo $insertado ? "Inserción Exitosa" : "Error de Inserción"; ?>
        </h2>
        <p class="">
            <?php echo $insertado ? "El padecimiento ha sido insertado exitosamente." : "Hubo un error al insertar el padecimiento. Por favor, intente de nuevo."; ?>
        </p>

        <div>
            <a href="../views/registrar/registrar_padecimiento.php" class="btn btn-primary">Volver a registrar padecimiento</a>
        </div>
    </div>
</section>

<?php require("../template/footer.php"); ?>