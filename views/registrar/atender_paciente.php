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
$query_medicamentos = "SELECT medicamento_id, nombre FROM medicamentos";
$stmt_medicamentos = $db->prepare($query_medicamentos);
$stmt_medicamentos->execute();
$medicamentos = $stmt_medicamentos->fetchAll(PDO::FETCH_ASSOC);

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
                <div class="form-group" style="display: none;" >
                    <label for="paciente_id">ID del Paciente:</label>
                    <input type="text" id="paciente_id" name="paciente_id" class="form-control"readonly value="<?php echo htmlspecialchars($paciente_data['paciente_id']); ?>">
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

                <div id="medicamentos-container">
                    <!-- Primer medicamento -->
                    <div class="form-group medicamento-item">
                        <label for="medicamento">Seleccione el Medicamento:</label>
                        <select id="medicamento" name="medicamento[]" class="form-control" required>
                            <option value="" disabled selected>Seleccione un medicamento</option>
                            <?php foreach ($medicamentos as $medicamento): ?>
                                <option value="<?php echo htmlspecialchars($medicamento['medicamento_id']); ?>">
                                    <?php echo htmlspecialchars($medicamento['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group tratamiento-container" style="display: none;">
                        <label for="tratamiento">Tratamiento:</label>
                        <textarea id="tratamiento" name="tratamiento[]" class="form-control"></textarea>

                        <!-- Spinner que será mostrado durante la carga del tratamiento -->
                        <div class="spinner" style="display: none;">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>
                <div>
                <!-- Botón para añadir otro medicamento -->
                <button id="add-medicamento" type="button" class="btn btn-secondary" style="display: none;">Añadir otro medicamento</button>
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
    let padecimientosSeleccionados = new Set(); // Conjunto para los diagnósticos seleccionados

    // Función para ocultar el botón si no hay opciones disponibles
    const verificarOpcionesRestantes = () => {
        const selects = diagnosticosContainer.querySelectorAll('select[name="diagnostico[]"]');
        const totalOptions = Array.from(selects[0].options).length - 1; // Excluir el "Seleccione un diagnóstico"
        if (padecimientosSeleccionados.size >= totalOptions) {
            addDiagnosticoButton.style.display = 'none'; // Ocultar el botón si se seleccionaron todos
        } else {
            addDiagnosticoButton.style.display = 'inline-block'; // Mostrar el botón si hay opciones restantes
        }
    };

    // Función para actualizar las opciones de todos los selects
    const actualizarOpciones = () => {
        const selects = diagnosticosContainer.querySelectorAll('select[name="diagnostico[]"]');

        selects.forEach(select => {
            const currentValue = select.value; // Diagnóstico actual seleccionado en este select
            Array.from(select.options).forEach(option => {
                // Si el diagnóstico está seleccionado en otro lugar, ocultarlo, excepto si es el actual
                if (padecimientosSeleccionados.has(option.value) && option.value !== currentValue) {
                    option.style.display = 'none';
                } else {
                    option.style.display = ''; // Mostrar opciones no seleccionadas
                }
            });
        });

        verificarOpcionesRestantes(); // Revisar si debe ocultarse el botón
    };

    // Detectar cambios en los selects
    diagnosticosContainer.addEventListener('change', function (e) {
        if (e.target && e.target.name === "diagnostico[]") {
            const select = e.target;
            const selectedValue = select.value;

            // Validar si el diagnóstico ya fue seleccionado en otro lugar
            if (padecimientosSeleccionados.has(selectedValue)) {
                alert('Este diagnóstico ya ha sido seleccionado.');
                select.value = ""; // Restablecer el select
            } else {
                // Remover el valor anterior si cambia la selección
                const previousValue = Array.from(select.options).find(option => option.selected && option.value !== selectedValue);
                if (previousValue) {
                    padecimientosSeleccionados.delete(previousValue.value);
                }

                // Agregar el nuevo valor al conjunto
                if (selectedValue) {
                    padecimientosSeleccionados.add(selectedValue);
                }

                actualizarOpciones(); // Actualizar las opciones disponibles
            }
        }
    });

    // Manejar el clic del botón "Añadir Padecimiento"
    addDiagnosticoButton.addEventListener('click', function () {
        // Validar que el último diagnóstico tenga un valor seleccionado
        const lastSelect = diagnosticosContainer.querySelector('.diagnostico-item:last-child select');
        if (!lastSelect || !lastSelect.value) {
            alert('Debe seleccionar un diagnóstico válido antes de agregar otro.');
            return;
        }

        // Crear un nuevo selector para diagnósticos
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

        // Agregar el nuevo selector al contenedor
        diagnosticosContainer.appendChild(newDiagnostico);

        actualizarOpciones(); // Actualizar las opciones disponibles en todos los selects
    });

    // Inicializar opciones y validaciones al cargar la página
    actualizarOpciones();

    // Verificar si ya hay un padecimiento seleccionado al cargar la página
    const primerSelect = diagnosticosContainer.querySelector('select[name="diagnostico[]"]');
    if (primerSelect && primerSelect.value) {
        addDiagnosticoButton.style.display = 'inline-block'; // Mostrar el botón si ya hay un padecimiento seleccionado
    } else {
        addDiagnosticoButton.style.display = 'none'; // Mantener el botón oculto si no hay selección
    }
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const medicamentosContainer = document.getElementById('medicamentos-container');
    const addMedicamentoButton = document.getElementById('add-medicamento');
    const medicamentosSeleccionados = new Set(); // Para almacenar medicamentos seleccionados

    // Función para mostrar el tratamiento
    const mostrarTratamiento = (medicamentoId, tratamientoContainer) => {
        const spinner = tratamientoContainer.querySelector('.spinner');
        const textarea = tratamientoContainer.querySelector('textarea');

        spinner.style.display = 'block';
        textarea.style.display = 'none';

        fetch(`../../ajax/get_tratamiento.php?medicamento_id=${medicamentoId}`)
            .then(response => response.json())
            .then(data => {
                const tratamiento = data.tratamiento || "Tratamiento no disponible";
                textarea.value = tratamiento;
                spinner.style.display = 'none';
                textarea.style.display = 'block';
            })
            .catch(error => {
                console.error('Error al obtener el tratamiento:', error);
                textarea.value = "Error al cargar el tratamiento.";
                spinner.style.display = 'none';
                textarea.style.display = 'block';
            });
    };

    // Función para actualizar las opciones de todos los selects
    const actualizarOpciones = () => {
        const todosLosSelects = medicamentosContainer.querySelectorAll('select');
        let totalOpcionesDisponibles = 0; // Contador de opciones disponibles

        todosLosSelects.forEach(select => {
            const opciones = select.querySelectorAll('option');
            opciones.forEach(opcion => {
                if (opcion.value && medicamentosSeleccionados.has(opcion.value)) {
                    opcion.style.display = 'none'; // Ocultar medicamentos ya seleccionados
                } else if (opcion.value) {
                    opcion.style.display = 'block'; // Mostrar medicamentos disponibles
                    totalOpcionesDisponibles++;
                }
            });
        });

        // Si ya no hay opciones disponibles, ocultamos el botón
        if (totalOpcionesDisponibles > 0) {
            addMedicamentoButton.style.display = 'inline-block'; // Mostrar botón
        } else {
            addMedicamentoButton.style.display = 'none'; // Ocultar botón
        }
    };

    // Función para agregar un nuevo medicamento
    const agregarMedicamento = () => {
        const nuevoMedicamentoItem = document.createElement('div');
        nuevoMedicamentoItem.classList.add('medicamento-item');

        nuevoMedicamentoItem.innerHTML = `
            <div class="form-group">
                <label for="medicamento">Seleccione el Medicamento:</label>
                <select name="medicamento[]" class="form-control" required>
                    <option value="" disabled selected>Seleccione un medicamento</option>
                    <?php foreach ($medicamentos as $medicamento): ?>
                        <option value="<?php echo htmlspecialchars($medicamento['medicamento_id']); ?>">
                            <?php echo htmlspecialchars($medicamento['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group tratamiento-container" style="display: none;">
                <label for="tratamiento">Tratamiento:</label>
                <textarea name="tratamiento[]" class="form-control" rows="3" readonly></textarea>
                <div class="spinner" style="display: none;">
                    <div class="loader"></div>
                </div>
            </div>
        `;

        medicamentosContainer.appendChild(nuevoMedicamentoItem);

        const medicamentoSelect = nuevoMedicamentoItem.querySelector('select');
        const tratamientoContainer = nuevoMedicamentoItem.querySelector('.tratamiento-container');

        // Evento al cambiar el select
        medicamentoSelect.addEventListener('change', function () {
            const medicamentoId = this.value;

            if (medicamentoId) {
                medicamentosSeleccionados.add(medicamentoId);
                tratamientoContainer.style.display = 'block';
                mostrarTratamiento(medicamentoId, tratamientoContainer);
                actualizarOpciones(); // Actualiza las opciones de todos los selects
            }
        });

        actualizarOpciones(); // Actualiza las opciones al agregar un nuevo select
    };

    // Manejar el primer `select` ya existente
    const primerSelect = medicamentosContainer.querySelector('select');
    const primerTratamientoContainer = medicamentosContainer.querySelector('.tratamiento-container');

    if (primerSelect) {
        primerSelect.addEventListener('change', function () {
            const medicamentoId = this.value;

            if (medicamentoId) {
                medicamentosSeleccionados.add(medicamentoId);
                primerTratamientoContainer.style.display = 'block';
                mostrarTratamiento(medicamentoId, primerTratamientoContainer);
                actualizarOpciones(); // Actualizar las opciones después de seleccionar
            }
        });

        actualizarOpciones(); // Asegurar que las opciones se actualizan al cargar
    }

    // Manejar el clic en "Añadir otro medicamento"
    addMedicamentoButton.addEventListener('click', agregarMedicamento);

    // Ocultar el botón inicialmente
    addMedicamentoButton.style.display = 'none';
});


</script>



<?php require("../../template/footer.php"); ?>
