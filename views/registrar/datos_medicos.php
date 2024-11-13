<?php
include "../../includes/Database.php";
include "../../includes/Citas.php";
include "../../includes/Datos_Medicos.php"; // Incluir la clase para los datos médicos
session_start();

$database = new Database();
$db = $database->getConnection();
$citas = new Citas($db);
$datos_medicos = new Datos_Medicos($db); // Instanciamos la clase de datos médicos

// Verificamos si el usuario está logeado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el paciente_id a partir del usuario_id en sesión
$usuario_id = $_SESSION['usuario_id'];
$paciente_id = $citas->obtener_paciente_id_por_usuario($usuario_id);

// Consultar los datos del paciente
$paciente_data = $citas->consultar_paciente_por_id($paciente_id);

if ($paciente_data === false) {
    $error = "Error en la consulta del paciente.";
    $paciente_data = [];
}

// Obtener los datos médicos del paciente (si existen)
$datos_medicos->paciente_id = $paciente_id;
$datos_medicos->obtenerPorPacienteId($paciente_id);

// Verificar si los datos médicos existen
$datos_existentes = isset($datos_medicos->altura) && isset($datos_medicos->peso) && isset($datos_medicos->tipo_sangre) && isset($datos_medicos->alergias);

// Mostrar mensajes de éxito o error
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}

require("../../template/header.php");
?>

<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-8">
            <h2 class="text-center">Formulario de Datos Médicos del Paciente</h2>
            <form action="../../controllers/procesar_datos_medicos.php" method="POST" class="form">
                <input type="hidden" id="paciente_id" name="paciente_id"  class="form-control" value="<?php echo htmlspecialchars($paciente_data['paciente_id']); ?>">

                <div class="form-group">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" readonly value="<?php echo htmlspecialchars($paciente_data['nombre']); ?>">
                </div>

                <!-- Datos Médicos -->
                <h3 class="mt-4">Datos Médicos</h3>

                <div class="form-group">
                    <label for="altura">Altura (cm):</label>
                    <input type="text" id="altura" name="altura" class="form-control" 
                    value="<?php echo isset($datos_medicos->altura) ? htmlspecialchars($datos_medicos->altura) : ''; ?>" 
                    <?php echo $datos_existentes ? 'readonly' : ''; ?>>
                </div>

                <div class="form-group">
                    <label for="peso">Peso (kg):</label>
                    <input type="text" id="peso" name="peso" class="form-control" 
                    value="<?php echo isset($datos_medicos->peso) ? htmlspecialchars($datos_medicos->peso) : ''; ?>" 
                    <?php echo $datos_existentes ? 'readonly' : ''; ?>>
                </div>

                <div class="form-group">
                    <label for="tipo_sangre">Tipo de Sangre:</label>
                    <input type="text" id="tipo_sangre" name="tipo_sangre" class="form-control" 
                    value="<?php echo isset($datos_medicos->tipo_sangre) ? htmlspecialchars($datos_medicos->tipo_sangre) : ''; ?>" 
                    <?php echo $datos_existentes ? 'readonly' : ''; ?>>
                </div>

                <div class="form-group">
                    <label for="alergias">Alergias:</label>
                    <textarea id="alergias" name="alergias" class="form-control" 
                    <?php echo $datos_existentes ? 'readonly' : ''; ?>><?php echo isset($datos_medicos->alergias) ? htmlspecialchars($datos_medicos->alergias) : ''; ?></textarea>
                </div>

                <!-- Mostrar el botón "Modificar" solo si ya existen datos médicos -->
                <?php if ($datos_existentes): ?>
                    <button type="button" class="btn btn-warning mt-3" id="editar_btn">Modificar</button>
                <?php endif; ?>

                <!-- El botón para guardar los cambios solo se habilitará cuando el formulario sea editable -->
                <button type="submit" class="btn btn-primary mt-3" id="guardar_btn" <?php echo $datos_existentes ? 'disabled' : ''; ?>>Guardar Datos Médicos</button>
            </form>
        </div>
    </div>
</section>

<?php require("../../template/footer.php"); ?>

<script>
    // Solo habilitar la edición si no existen datos médicos previos
    if (<?php echo $datos_existentes ? 'true' : 'false'; ?>) {
        document.getElementById('editar_btn').addEventListener('click', function() {
            // Cambiar el comportamiento del botón para habilitar la edición
            document.getElementById('altura').removeAttribute('readonly');
            document.getElementById('peso').removeAttribute('readonly');
            document.getElementById('tipo_sangre').removeAttribute('readonly');
            document.getElementById('alergias').removeAttribute('readonly');

            // Habilitar el botón de guardar
            document.getElementById('guardar_btn').removeAttribute('disabled');

            // Cambiar el texto del botón de "Modificar" a "Cancelar" (opcional)
            this.textContent = 'Cancelar Edición';
            this.classList.remove('btn-warning');
            this.classList.add('btn-danger');
        });
    } else {
        // Si no existen datos médicos, habilitar los campos de inmediato para la edición
        document.getElementById('altura').removeAttribute('readonly');
        document.getElementById('peso').removeAttribute('readonly');
        document.getElementById('tipo_sangre').removeAttribute('readonly');
        document.getElementById('alergias').removeAttribute('readonly');

        // Habilitar el botón de guardar
        document.getElementById('guardar_btn').removeAttribute('disabled');
    }
</script>
