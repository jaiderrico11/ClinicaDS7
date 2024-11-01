<?php
include "../includes/Database.php";
include "../includes/Medicos.php";
session_start();

$database = new Database();
$db = $database->getConnection();

$medicos = new Medicos($db);
$medicos->medico_id = $_SESSION['usuario_id'];
$result = $medicos->consultar_pacientes();



if ($result === false) {
    $error = "Error en la consulta.";
    $result = [];
}
?>

<?php require("../template/header.php"); ?>
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
                                <th>Fecha de Nacimiento</th>
                                <th>Genero</th>
                                <th>Telefono</th>
                                <th>Direccion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row["Cedula"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Paciente"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Fecha_Nacimiento"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Genero"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Telefono"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Direccion"]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="text-center">
                    <p>No hay citas pacientes</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    

    <?php require("../template/footer.php"); ?>