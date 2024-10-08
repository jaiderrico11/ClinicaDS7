<?php
include "../includes/Database.php";
include "../includes/Usuarios.php";

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

$usuarios = new Usuarios($db);

$usuarios->nombre = $_POST['nombre'];
$usuarios->email = $_POST['email'];
$usuarios->contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
$usuarios->rol = $_POST['rol'];

// Registrar el servicio médico
if ($usuarios->registrar_usuarios()) {
    $resultado = "Usuario registrado exitosamente.";
} else {
    $resultado = "Error al registrar el Usuario.";
}

?>

<?php require("../template/header.php"); ?>

<section class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="text-center border p-5">
            <?php echo $resultado; ?>
            <p class="mt-3">Redirigiendo en 5 segundos a la lista de usuarios</p>
        </div>
    </div>
</section>

<!-- Script para redirigir después de 5 segundos -->
<script>
    setTimeout(function() {
        window.location.href = "../views/lista_usuarios.php";
    }, 5000);
</script>

<?php require("../template/footer.php"); ?>