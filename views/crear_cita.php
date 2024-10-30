<?php require("../template/header.php");
$cita_id = htmlspecialchars($_GET["cita_id"]);
$nombre = htmlspecialchars($_GET["nombre"]);
?>

<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <form action="../controllers/procesar_cita.php" method="post">
                <input class="d-none" type="number" id="cita_id" name="cita_id" value="<?php echo $cita_id ?>">

                <div class="mb-3">
                    <label for="paciente" class="form-label">Paciente</label>
                    <input disabled type="text" required id="paciente" name="paciente" class="form-control" value="<?php echo $nombre ?>">
                </div>

                <div class="mb-3">
                    <label for="servicio" class="form-label">Servicio</label>
                    <select required name="servicio" id="servicio" class="form-select">
                        <option value="" selected disabled>Seleccione un servicio</option>
                        <?php
                        require_once "../includes/Database.php";
                        // Crear una instancia de la clase Database y obtener la conexión
                        $database = new Database();
                        $db = $database->getConnection();

                        $stmt = $db->query("SELECT * FROM servicios_medicos");

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['servicio_id'] . "'>" . htmlspecialchars($row['nombre_servicio']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="medico" class="form-label">Médico</label>
                    <select required name="medico" id="medico" class="form-select">
                        <option value="" selected disabled>Seleccione un médico</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" required id="fecha" name="fecha" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="hora" class="form-label">Hora</label>
                    <input type="time" required id="hora" name="hora" class="form-control">
                </div>

                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-primary">Crear cita</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#servicio').change(function() {
            let servicioID = $(this).val();

            if (servicioID) {
                $.ajax({
                    type: 'POST',
                    url: '../ajax/get_medicos.php',
                    data: {
                        servicio_id: servicioID
                    },
                    success: function(html) {
                        $('#medico').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener los servicios:', error);
                    }
                });
            } else {
                $('#medico').html('<option value="">Seleccione un médico</option>');
            }
        });
    });
</script>

<?php require("../template/footer.php") ?>