<?php
include "../includes/Database.php";
include "../includes/Usuarios.php";

$database = new Database();
$db = $database->getConnection();

$usuarios = new Usuarios($db);
$usuarios->usuario_id = $_POST["usuario_id"];
$usuarios->nombre = $_POST["nombre"];
$usuarios->email = $_POST["email"];
$usuarios->rol = $_POST["rol"];

$actualizado = $usuarios->actualizar_usuarios();
?>

<?php require("../template/header.php"); ?>

<section class="container mt-5">
    <div class="text-center">
        <h2 class="mb-4">
            <?php echo $actualizado ? "Actualización Exitosa" : "Error de Actualización"; ?>
        </h2>
        <p class="">
            <?php echo $actualizado ? "El usuario ha sido actualizado exitosamente." : "Hubo un error al actualizar el usuario. Por favor, intente de nuevo."; ?>
        </p>

        <div>
            <a href="../views/lista_usuarios.php" class="btn btn-primary">Volver a lista de usuarios</a>
        </div>
    </div>
</section>

<?php require("../template/footer.php"); ?>