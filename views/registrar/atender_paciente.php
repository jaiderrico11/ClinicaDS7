<?php
include "../../includes/Database.php";
include "../../includes/Citas.php";
include "../../includes/Datos_Medicos.php"; // Incluir la clase de datos médicos
session_start();

$database = new Database();
$db = $database->getConnection();

$citas = new Citas($db);
$datos_medicos = new Datos_Medicos($db); // Instanciar la clase para los datos médicos

// Inicialización de variables
$padecimientos = [];

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

    // Consulta para obtener los padecimientos
    $query_padecimientos = "SELECT id_padecimiento, padecimiento FROM padecimiento";
    $stmt = $db->prepare($query_padecimientos);
    $stmt->execute();
    $padecimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <!-- Diagnóstico -->
                <h3 class="mt-4">Diagnóstico</h3>
                <div id="diagnosticos-container">
                    <div class="form-group diagnostico-item">
                        <label for="diagnostico">Diagnóstico:</label>
                        <select id="diagnostico" name="diagnostico[]" class="form-control" required>
                            <option value="" disabled selected>Seleccione un diagnóstico</option>
                            <?php foreach ($padecimientos as $padecimiento): ?>
                                <option value="<?php echo htmlspecialchars($padecimiento['id_padecimiento']); ?>">
                                    <?php echo htmlspecialchars($padecimiento['padecimiento']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary mt-2" id="add-diagnostico">Añadir Padecimiento</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const diagnosticosContainer = document.getElementById('diagnosticos-container');
    const addDiagnosticoButton = document.getElementById('add-diagnostico');
    let padecimientosSeleccionados = new Set(); // Para almacenar los diagnósticos seleccionados

    // Ocultar el botón inicialmente
    addDiagnosticoButton.style.display = 'none';

    // Función para verificar el último select
    const validarUltimoDiagnostico = () => {
        const lastSelect = diagnosticosContainer.querySelector('.diagnostico-item:last-child select');
        const selectedValue = lastSelect ? lastSelect.value : '';

        if (selectedValue && !padecimientosSeleccionados.has(selectedValue)) {
            addDiagnosticoButton.style.display = 'inline-block'; // Mostrar el botón
        } else {
            addDiagnosticoButton.style.display = 'none'; // Ocultar el botón
        }
    };

    // Detectar cambios en los selects
    diagnosticosContainer.addEventListener('change', function (e) {
        if (e.target && e.target.name === "diagnostico[]") {
            const selectedValue = e.target.value;

            if (padecimientosSeleccionados.has(selectedValue)) {
                alert('Este diagnóstico ya ha sido seleccionado.');
                e.target.value = ""; // Restablecer el select
            } else {
                validarUltimoDiagnostico(); // Verificar si el botón debe mostrarse
            }
        }
    });

    // Manejar el clic del botón "Añadir Padecimiento"
    addDiagnosticoButton.addEventListener('click', function () {
        const lastSelect = diagnosticosContainer.querySelector('.diagnostico-item:last-child select');
        const selectedValue = lastSelect ? lastSelect.value : '';

        if (!selectedValue || padecimientosSeleccionados.has(selectedValue)) {
            alert('Debe seleccionar un diagnóstico válido antes de agregar otro.');
            return;
        }

        // Agregar el diagnóstico seleccionado al conjunto
        padecimientosSeleccionados.add(selectedValue);

        // Crear un nuevo select para diagnóstico
        const newDiagnostico = document.createElement('div');
        newDiagnostico.classList.add('form-group', 'diagnostico-item');

        newDiagnostico.innerHTML = `
            <label for="diagnostico">Diagnóstico:</label>
            <select id="diagnostico" name="diagnostico[]" class="form-control" required>
                <option value="" disabled selected>Seleccione un diagnóstico</option>
                <?php foreach ($padecimientos as $padecimiento): ?>
                    <option value="<?php echo htmlspecialchars($padecimiento['id_padecimiento']); ?>">
                        <?php echo htmlspecialchars($padecimiento['padecimiento']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        `;

        // Agregar el nuevo select al contenedor
        diagnosticosContainer.appendChild(newDiagnostico);

        // Ocultar el botón hasta que se seleccione un nuevo diagnóstico
        addDiagnosticoButton.style.display = 'none';
    });

    // Inicializar validación del botón al cargar la página
    validarUltimoDiagnostico();
});
</script>

<?php require("../../template/footer.php"); ?>
