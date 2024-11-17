<?php
include "../includes/Database.php";
include "../includes/Padecimientos.php";

$database = new Database();
$db = $database->getConnection();

$padecimientos = new Padecimientos($db);

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $padecimientos->padecimiento = $_POST["padecimiento"];

    if ($padecimientos->insertar_padecimiento()) {
        $success_message = 'Padecimiento insertado exitosamente.';
    } else {
        $error_message = 'Error al insertar el padecimiento.';
    }
}

require("../template/header.php");
?>
<section class="container mt-5">
    <div class="text-center">
        <h2 class="mb-4">
            <?php echo !empty($success_message) ? "Inserción Exitosa" : "Error de Inserción"; ?>
        </h2>
        <p class="">
            <?php echo !empty($success_message) ? $success_message : $error_message; ?>
        </p>
        <div>
            <a href="../views/registrar/registrar_padecimiento.php" class="btn btn-primary">Volver a registrar padecimiento</a>
        </div>
    </div>
</section>
<?php require("../template/footer.php"); ?>