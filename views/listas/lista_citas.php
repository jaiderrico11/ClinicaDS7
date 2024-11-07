<?php
require "../../template/header.php";
require "../../includes/Database.php";
require "../../includes/Pacientes.php";
session_start();
$database = new Database();
$db = $database->getConnection();

$pacientes = new Pacientes($db);
$pacientes->paciente_id = $_SESSION["usuario_id"];
$result = $pacientes->consultar_citas();

if ($result === false) {
    $error = "Error en la consulta.";
    $result = [];
}
?>

<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <?php if (isset($result) && !empty($result)) : ?>
            <div class="table-responsive">
                <h1 class="text-center">Citas del dia</h1>
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Especialidad</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Médico</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row) : ?>
                            <?php if (empty($row["Fecha"]) && empty($row["hora"]) && empty($row["Medico"])) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row["Especialidad"]); ?></td>
                                    <td colspan="4" class="text-center">La cita aún no ha sido agendada</td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row["Especialidad"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Fecha"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Hora"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Medico"]); ?></td>
                                    <td>
                                        <a href="../eliminar/cancelar_cita.php?cita_id=<?php echo $row["cita_id"]; ?>" class="btn btn-danger">Cancelar</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="text-center">
                <p>No tienes citas.</p>
            </div>
        <?php endif; ?>
    </div>
</section>


<?php require "../../template/footer.php"; ?>