<?php
require("../../template/header.php");
include("../../includes/Database.php");
include("../../includes/Medicos.php");

$database = new Database();
$db = $database->getConnection();

// Instancia de la clase Medicos
$medicos = new Medicos($db);
$lista_medicos = $medicos->consultar_medicos_disponibles();
?>

<a href="../inicio/inicio_recepcionista.php" class="btn btn-secondary my-3 mx-4">Regresar</a>

<!-- Contenido principal -->
<section class="container mt-5">
    <h1 class="text-center">Gestión de Médicos</h1>
    <div class="row my-4 d-flex justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <label for="medico" class="form-label">Seleccione al médico:</label>
                    <select id="medico" class="form-select mt-3" onchange="cargarCitas(this.value)">
                        <?php
                        // Carga los médicos en el select
                        if ($lista_medicos) {
                            foreach ($lista_medicos as $medico) {
                                // Asegúrate de que 'nombre' existe en tu arreglo
                                echo "<option value='{$medico['medico_id']}'>{$medico['nombre']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="citasContainer" class="container mt-5">
    <!-- Aquí se cargarán las citas -->
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Llama a la función cargarCitas cuando la página esté lista
        var medicoId = $('#medico').val(); // Obtiene el valor del médico seleccionado
        if (medicoId) {
            cargarCitas(medicoId); // Carga las citas automáticamente
        }
    });

    function cargarCitas(medicoId) {
        $.ajax({
            url: '../../ajax/get_disponibilidad_medico.php', // Cambia esto al nombre correcto de tu archivo PHP
            type: 'GET',
            data: {
                medico_id: medicoId
            },
            success: function(data) {
                $('#citasContainer').html(data); // Cargar la respuesta en un contenedor
            },
            error: function(xhr, status, error) {
                console.error(error);
                $('#citasContainer').html('<p>Error al cargar las citas.</p>');
            }
        });
    }
</script>

<?php require("../../template/footer.php") ?>