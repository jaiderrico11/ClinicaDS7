<?php require("../../template/header.php");
$cita_id = htmlspecialchars($_GET["cita_id"]);
$nombre = htmlspecialchars($_GET["nombre"]);
?>
<section class="container">
    <a href="../inicio/inicio_recepcionista.php" class="btn btn-secondary my-3 mx-4">Regresar</a>
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <h1 class="text-center">Crear Cita</h1>
            <form action="../../controllers/procesar_cita.php" method="post">
                <input class="d-none" type="number" id="cita_id" name="cita_id" value="<?php echo $cita_id ?>">

                <div class="mb-3">
                    <label for="paciente" class="form-label">Paciente</label>
                    <input disabled type="text" required id="paciente" name="paciente" class="form-control" value="<?php echo $nombre ?>">
                </div>

                <div class="mb-3">
                    <label for="servicio" class="form-label">Servicio</label>
                    <select disabled name="servicio" id="servicio" class="form-select">
                        <option value="" selected disabled>Seleccione un servicio</option>
                        <?php
                        require_once "../../includes/Database.php";
                        // Crear una instancia de la clase Database y obtener la conexión
                        $database = new Database();
                        $db = $database->getConnection();
                        // Obtener el servicio_id de la cita
                        $query = $db->prepare("SELECT servicio_id FROM citas WHERE cita_id = :cita_id");
                        $query->bindParam(':cita_id', $cita_id, PDO::PARAM_INT);
                        $query->execute();
                        $servicio = $query->fetch(PDO::FETCH_ASSOC);

                        // Asegurarse de que servicio_id se obtuvo correctamente
                        $servicio_id = $servicio ? $servicio['servicio_id'] : null;
                        $stmt = $db->query("SELECT * FROM servicios_medicos");

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row["servicio_id"] == $servicio_id) ? "selected" : "";
                            echo "<option value='" . $row['servicio_id'] . "' $selected>" . htmlspecialchars($row['nombre_servicio']) . "</option>";
                        }
                        ?>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input readonly type="date" required id="fecha" name="fecha" class="form-control"
                        value="<?php
                                $query = $db->prepare("SELECT * FROM citas WHERE cita_id = :cita_id");
                                $query->bindParam(':cita_id', $cita_id, PDO::PARAM_INT);
                                $query->execute();
                                $citas = $query->fetch(PDO::FETCH_ASSOC);
                                echo $citas["fecha"]; ?>">
                </div>

                <div class="mb-3">
                    <label for="medico" class="form-label">Médico</label>
                    <select required name="medico" id="medico" class="form-select">
                        <option value="" selected disabled>Seleccione un médico</option>
                        <?php
                        require_once "../../includes/Database.php";
                        require_once "../../includes/Medicos.php";
                        // Crear una instancia de la clase Database y obtener la conexión
                        $database = new Database();
                        $db = $database->getConnection();
                        $medicos = new Medicos($db);
                        // Obtener el medico dependiendo del dia y el turno
                        $query = $db->prepare("SELECT * FROM citas WHERE cita_id = :cita_id");
                        $query->bindParam(':cita_id', $cita_id, PDO::PARAM_INT);
                        $query->execute();
                        $turno = $query->fetch(PDO::FETCH_ASSOC);
                        $stmt = $medicos->consultar_medicos_disponibles($turno["id_turno"], $citas["fecha"]);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['usuario_id'] . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="hora" class="form-label">Hora</label>
                    <select required name="hora" id="hora" class="form-select">
                        <option value="" selected disabled>Seleccione una hora</option>

                    </select>
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
        // Detectar el evento de cambio en el combobox de medico
        $('#medico').change(function() {
            // Obtener el valor seleccionado del combobox de medico
            let medicoID = $(this).val();

            // Verificar si se ha seleccionado un medico válido
            if (medicoID) {
                $.ajax({
                    type: 'POST',
                    url: '../../ajax/get_horas_disponibles.php',
                    data: {
                        medico_id: medicoID,
                        id_turno: <?php echo $citas["id_turno"] ?>
                    },
                    success: function(html) {
                        $('#hora').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener las horas:', error);
                    }
                });
            } else {
                $('#hora').html('<option value="">Seleccione una hora</option>');
            }
        });
    });
</script>
<?php require("../../template/footer.php") ?>