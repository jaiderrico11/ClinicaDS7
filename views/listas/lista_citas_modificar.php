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

    <!-- Formulario para buscar por cédula -->
    <form method="GET" class="my-4 d-flex justify-content-center">
        <input type="text" name="cedula" class="form-control mx-2" placeholder="Ingrese la cédula" required>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <div class="row d-flex justify-content-center align-items-center">
        <?php
        if (isset($_GET['cedula'])) {
            $cedula = htmlspecialchars($_GET['cedula']);

            $result = $citas->consultar_cita_por_paciente($cedula);

            if (!empty($result)) :
        ?>
                <div class="table-responsive">
                    <h1 class="text-center">Lista de Citas</h1>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row["Servicio"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Fecha"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["Hora"]); ?></td>
                                    <td>
                                        <a href="../registrar/modificar_cita.php?nombre=<?php echo htmlspecialchars($row["Paciente"]); ?>&cita_id=<?php echo htmlspecialchars($row["cita_id"]); ?>" class="btn btn-primary">Modificar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="text-center">
                    <p>No hay citas para la cédula ingresada.</p>
                </div>
        <?php endif;
        } else {
            echo '<div class="text-center"><p>Ingrese una cédula para buscar las citas.</p></div>';
        }
        ?>
    </div>
</section>


<?php require("../../template/footer.php"); ?>