<?php
include "../includes/Database.php";
include "../includes/Usuarios.php";

$database = new Database();
$db = $database->getConnection();

$usuarios = new Usuarios($db);
$usuarios->usuario_id = $_POST["usuario_id"];

$mensaje = $usuarios->eliminar_usuarios();
?>

<?php require("../template/header.php"); ?>

<section class="container mt-5">
    <div class="text-center">
        <h2 class="mb-4">
            <?php echo $mensaje ? "Eliminación Exitosa" : "Error al Eliminar"; ?>
        </h2>
        <p class="">
            <?php echo $mensaje ? "El usuario ha sido eliminado exitosamente." : "Hubo un error al eliminar el usuario. Por favor, intente de nuevo."; ?>
        </p>

        <div>
            <a href="../views/lista_usuarios.php" class="btn btn-primary">Volver a lista de usuarios</a>
        </div>
    </div>
</section>

<?php require("../template/footer.php"); ?>