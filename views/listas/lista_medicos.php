<?php
// Incluimos las dependencias necesarias
require("../../includes/Database.php");
require("../../includes/Usuarios.php");

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciamos la clase Usuarios para obtener los médicos
$usuarios = new Usuarios($db);
$medicos = $usuarios->consultar_medicos_por_rol(); // Obtener los usuarios con rol 'medico'

?>

<?php require("../../template/header.php"); ?>
<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
<?php endif; ?>
<a href="../../index.php" class="btn btn-secondary my-3 mx-4">Regresar</a>

<section class="container mt-2">
    <h2>Lista de Médicos Registrados</h2>
    <?php if (!empty($medicos)) : ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicos as $medico) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($medico['usuario_id']); ?></td>
                            <td><?php echo htmlspecialchars($medico['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($medico['email']); ?></td>
                            <td>
                                <a href="../actualizar/actualizar_medico.php?id=<?php echo $medico['usuario_id']; ?>" class="btn btn-primary">Actualizar</a>
                                <a href="../eliminar/eliminar_medico.php?id=<?php echo $medico['usuario_id']; ?>" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="text-center">
            <p>No hay médicos registrados.</p>
        </div>
    <?php endif; ?>
</section>

<?php require("../../template/footer.php"); ?>