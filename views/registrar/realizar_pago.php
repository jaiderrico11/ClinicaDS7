<?php
require("../../template/header.php");
include("../../includes/Database.php");
include("../../includes/Facturas.php");
include("../../includes/Citas.php");

session_start();
$database = new Database();
$db = $database->getConnection();

// Instancia de las clases Facturas y Citas
$facturas = new Facturas($db);
$citas = new Citas($db);

// Asegúrate de tener el ID de usuario disponible
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id']; // Obtener ID de la sesión
} else {
    // Manejo del error si no está definido
    echo '<p>No se ha encontrado el ID del usuario. Por favor, inicie sesión nuevamente.</p>';
    exit; // Detener la ejecución si no hay usuario_id
}

// Buscar el paciente por usuario_id
$paciente_id = $citas->obtener_paciente_id_por_usuario($usuario_id);

if (!$paciente_id) {
    echo '<p>No se ha encontrado el paciente asociado al usuario.</p>';
    exit; // Detener la ejecución si no se encuentra el paciente
}

// Consultar citas atendidas
$citas_atendidas = $citas->consultar_citas_atendidas_por_paciente($paciente_id);
?>

<a href="../inicio/inicio_paciente.php" class="btn btn-secondary my-3 mx-4">Regresar</a>

<section class="container mt-5">
    <h1 class="text-center">Citas Atendidas</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($citas_atendidas) > 0): ?>
                    <?php foreach ($citas_atendidas as $cita): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cita["fecha"]); ?></td>
                            <td><?php echo htmlspecialchars($cita["hora"]); ?></td>
                            <td><?php echo htmlspecialchars($cita["costo"]); ?></td>
                            <td>
                                <form action="../../controllers/procesar_pago.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="cita_id" value="<?php echo htmlspecialchars($cita["cita_id"]); ?>">
                                    <input type="hidden" name="paciente_id" value="<?php echo htmlspecialchars($paciente_id); ?>">
                                    <input type="hidden" name="amount" value="<?php echo htmlspecialchars($cita["costo"]); ?>">
                                    <button type="submit" class="btn btn-warning">Pagar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No tiene citas atendidas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require("../../template/footer.php") ?>
