<?php
include "../../includes/Database.php";
include "../../includes/Citas.php";
session_start();

$database = new Database();
$db = $database->getConnection();

$citas = new Citas($db);
$citas->medico_id = $_SESSION['usuario_id'];
$result = $citas->consultar_citas_del_dia();
$result1 = $citas->consultar_proximas_citas();


if ($result === false) {
    $error = "Error en la consulta.";
    $result = [];
}
?>

<?php require("../../template/header.php"); ?>
    <section class="container">
        <div class="row d-flex justify-content-center align-items-center min-vh-90">
            <?php if (isset($result) && !empty($result)) : ?>
                <div class="table-responsive">
                <h1 class="text-center">Citas del dia</h1>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Cedula</th>
                                <th>Paciente</th>
                                <th>hora</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row["Cedula"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Paciente"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["hora"]); ?></td>
                                    <td>
                                        <a href="../registrar/atender_paciente.php?paciente_id=<?php echo htmlspecialchars($row["paciente_id"]); ?>" class="btn btn-primary">Atender</a>
                                        <a href="../registrar/crear_cita.php" class="btn btn-primary">Reagendar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="text-center">
                    <p>No hay citas en el dia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="container">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <?php if (isset($result1) && !empty($result1)) : ?>
                <div class="table-responsive">
                <h1 class="text-center">Proximas Citas</h1>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Cedula</th>
                                <th>Paciente</th>
                                <th>hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result1 as $row) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row["Cedula"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Paciente"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["hora"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="text-center">
                    <p>No hay proximas citas.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php require("../../template/footer.php"); ?>