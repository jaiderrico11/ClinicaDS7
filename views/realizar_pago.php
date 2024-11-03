<?php
require("../template/header.php");
include("../includes/Database.php");
include("../includes/Facturas.php");
include("../includes/Citas.php");

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

<a href="./inicio_paciente.php" class="btn btn-secondary my-3 mx-4">Regresar</a>

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
                                <button class="btn btn-warning" data-toggle="modal" data-target="#paymentModal" data-cita-id="<?php echo htmlspecialchars($cita["cita_id"]); ?>" data-costo="<?php echo htmlspecialchars($cita["costo"]); ?>">Pagar</button>
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

<!-- Modal para el formulario de pago -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Formulario de Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="paymentForm" action="../controllers/procesar_pago.php" method="POST">
                    <input type="hidden" id="cita_id" name="cita_id">
                    <input type="hidden" id="paciente_id" name="paciente_id" value="<?php echo htmlspecialchars($paciente_id); ?>">
                    <div class="form-group">
                        <label for="card_number">Número de tarjeta</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="Número de tarjeta" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry_date">Fecha de expiración</label>
                        <input type="month" class="form-control" id="expiry_date" name="expiry_date" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Monto</label>
                        <input type="text" class="form-control" id="amount" name="amount" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Pagar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Escuchar el evento de mostrar el modal para el formulario de pago
    $('#paymentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que abrió el modal
        var citaId = button.data('cita-id'); // Obtener el ID de la cita desde el botón
        var costo = button.data('costo'); // Obtener el costo desde el botón

        // Asignar valores a los campos del formulario en el modal
        var modal = $(this);
        modal.find('#cita_id').val(citaId);
        modal.find('#amount').val(costo); // Mapear el costo en el campo de monto
    });
</script>
<?php require("../template/footer.php") ?>
