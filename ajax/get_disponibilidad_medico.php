<?php
include "../includes/Database.php";
include "../includes/Citas.php";
session_start();

$database = new Database();
$db = $database->getConnection();

$citas = new Citas($db);

// Verifica si se ha pasado el ID del médico
if (isset($_GET['medico_id'])) {
    $citas->medico_id = $_GET['medico_id']; // Asigna el ID del médico

    $result = $citas->consultar_citas_del_dia(); // Cambia si necesitas consultar algo diferente
    $result1 = $citas->consultar_proximas_citas();

    if ($result === false) {
        $error = "Error en la consulta.";
        $result = [];
    }

    // Incluye aquí el HTML que mostrará las citas
    ?>
    <h1 class="text-center">Citas del día</h1>
    <div class="table-responsive">
        <?php if (!empty($result)) : ?>
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Cedula</th>
                        <th>Paciente</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["Cedula"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Paciente"]); ?></td>
                            <td><?php echo htmlspecialchars($row["hora"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="text-center">
                <p>El Médico se encuentra disponible.</p>
            </div>
        <?php endif; ?>
    </div>

    <h1 class="text-center">Próximas Citas</h1>
    <div class="table-responsive">
        <?php if (!empty($result1)) : ?>
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Cedula</th>
                        <th>Paciente</th>
                        <th>Hora</th>
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
        <?php else : ?>
            <div class="text-center">
                <p>El Médico se encuentra disponible.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php
} else {
    echo '<p>No se ha seleccionado ningún médico.</p>';
}
?>
