<?php
include "../includes/Database.php";
include "../includes/Usuarios.php";

$database = new Database();
$db = $database->getConnection();

$usuarios = new Usuarios($db);

$result = $usuarios->consultar_usuarios();

if ($result === false) {
    $error = "Error en la consulta.";
    $result = [];
}
?>

<?php require("../template/header.php"); ?>

<a href="../views/admin_inicio.php" class="btn btn-secondary my-3 mx-4">Regresar</a>

<section class="container mt-2">
    <h2>Lista de Usuarios</h2>
    <?php if (isset($result) && !empty($result)) : ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["usuario_id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["nombre"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td><?php echo htmlspecialchars($row["rol"]); ?></td>
                            <td>
                                <a href="./actualizar_usuario.php?usuario_id=<?php echo $row["usuario_id"]; ?>" class="btn btn-primary">Actualizar</a>
                                <a href="./eliminar_usuario.php?usuario_id=<?php echo $row["usuario_id"]; ?>" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="text-center">
            <p>No hay usuarios registrados.</p>
        </div>
    <?php endif; ?>
</section>

<?php require("../template/footer.php"); ?>