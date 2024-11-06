<?php
include "../../includes/Database.php";
include "../../includes/Citas.php";

$database = new Database();
$db = $database->getConnection();

$citas = new Citas($db);

$result = $citas->consultar_citas();

if ($result === false) {
    $error = "Error en la consulta.";
    $result = [];
}
?>

<?php require("../../template/header.php"); ?>
<section class="container">
    <a href="../inicio/inicio_recepcionista.php" class="btn btn-secondary my-3 mx-4">Regresar</a>
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <?php if (isset($result) && !empty($result)) : ?>
            <div class="table-responsive">
                <h1 class="text-center">Solicitudes de citas</h1>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Paciente</th>
                            <th>Servicio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["Paciente"]); ?></td>
                                <td><?php echo htmlspecialchars($row["Servicio"]); ?></td>
                                <td>
                                    <a href="../registrar/crear_cita.php?nombre=<?php echo htmlspecialchars($row["Paciente"]); ?>&cita_id=<?php echo htmlspecialchars($row["cita_id"]); ?>" class="btn btn-primary">Procesar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="text-center">
                <p>No hay citas pendientes.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require("../../template/footer.php"); ?>