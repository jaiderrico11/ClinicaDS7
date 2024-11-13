<?php
include "../../includes/Database.php";
include "../../includes/Citas.php";
include "../../includes/Datos_Medicos.php"; // Incluir la clase de datos médicos
session_start();

$database = new Database();
$db = $database->getConnection();

$citas = new Citas($db);
$datos_medicos = new Datos_Medicos($db); // Instanciar la clase para los datos médicos

// Verificamos si se ha pasado un ID de paciente
if (isset($_GET['paciente_id'])) {
    $paciente_id = $_GET['paciente_id'];

    // Consulta para obtener datos del paciente
    $paciente_data = $citas->consultar_paciente_por_id($paciente_id);

    if ($paciente_data === false) {
        $error = "Error en la consulta del paciente.";
        $paciente_data = [];
    }

    // Obtener los datos médicos del paciente
    $datos_medicos->paciente_id = $paciente_id;
    $datos_medicos_data = $datos_medicos->obtenerPorPacienteId($paciente_id);
} else {
    // Manejar el caso cuando no se proporciona un ID
    $error = "No se ha proporcionado el ID del paciente.";
    $paciente_data = [];
    $datos_medicos_data = [];
}

// Mostrar mensajes de éxito o error
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']); // Limpiar el mensaje después de mostrarlo
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Limpiar el mensaje después de mostrarlo
}

require("../../template/header.php");
?>

<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-8">
            <h2 class="text-center">Formulario de Atención al Paciente</h2>
            <form action="../../controllers/procesar_atencion.php" method="POST" class="form">

                <!-- Datos Básicos del Paciente -->
                <h3 class="mt-4">Datos Básicos del Paciente</h3>
                <div class="form-group">
                    <label for="paciente_id">ID del Paciente:</label>
                    <input type="text" id="paciente_id" name="paciente_id" class="form-control" readonly value="<?php echo htmlspecialchars($paciente_data['paciente_id']); ?>">
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" readonly value="<?php echo htmlspecialchars($paciente_data['nombre']); ?>">
                </div>

                <div class="form-group">
                    <label for="cedula">Cedula:</label>
                    <input type="text" id="cedula" name="cedula" class="form-control" readonly value="<?php echo htmlspecialchars($paciente_data['cedula']); ?>">
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" readonly value="<?php echo htmlspecialchars($paciente_data['fecha_nacimiento']); ?>">
                </div>

                <div class="form-group">
                    <label for="genero">Género:</label>
                    <input type="text" id="genero" name="genero" class="form-control" readonly value="<?php echo htmlspecialchars($paciente_data['genero']); ?>">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" readonly value="<?php echo htmlspecialchars($paciente_data['telefono']); ?>">
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="form-control" readonly value="<?php echo htmlspecialchars($paciente_data['direccion']); ?>">
                </div>

                <!-- Diagnóstico -->
                <h3 class="mt-4">Diagnóstico</h3>
                <div class="form-group">
                    <label for="diagnostico">Diagnóstico:</label>
                    <input type="text" id="diagnostico" name="diagnostico" class="form-control" required>
                </div>

                <!-- Datos Médicos -->
                <h3 class="mt-4">Datos Médicos</h3>

                <div class="form-group">
                    <label for="altura">Altura (cm):</label>
                    <input type="text" id="altura" name="altura" class="form-control" 
                    value="<?php echo isset($datos_medicos->altura) ? htmlspecialchars($datos_medicos->altura) : ''; ?>" readonly required>
                </div>

                <div class="form-group">
                    <label for="peso">Peso (kg):</label>
                    <input type="text" id="peso" name="peso" class="form-control" 
                    value="<?php echo isset($datos_medicos->peso) ? htmlspecialchars($datos_medicos->peso) : ''; ?>" readonly required>
                </div>

                <div class="form-group">
                    <label for="tipo_sangre">Tipo de Sangre:</label>
                    <input type="text" id="tipo_sangre" name="tipo_sangre" class="form-control" 
                    value="<?php echo isset($datos_medicos->tipo_sangre) ? htmlspecialchars($datos_medicos->tipo_sangre) : ''; ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="alergias">Alergias:</label>
                    <textarea id="alergias" name="alergias" class="form-control" readonly required><?php echo isset($datos_medicos->alergias) ? htmlspecialchars($datos_medicos->alergias) : ''; ?></textarea>
                </div>

                <!-- Receta Médica -->
                <h3 class="mt-4">Receta Médica</h3>

                <div class="form-group">
                    <label for="medicamento">Medicamento:</label>
                    <input type="text" id="medicamento" name="medicamento" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="tratamiento">Tratamiento:</label>
                    <textarea id="tratamiento" name="tratamiento" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Guardar Atención</button>
            </form>
        </div>
    </div>
</section>

<?php require("../../template/footer.php"); ?>
