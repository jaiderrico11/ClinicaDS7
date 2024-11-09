<?php require("../../template/header.php") ?>

<section class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <form action="../../controllers/procesar_solicitar_cita.php" method="post">
            <div class="form-group">
                <label for="servicio">Servicio</label>
                <select required name="servicio" id="servicio" class="form-select">
                    <option value="" selected disabled>Seleccione un servicio</option>
                    <?php
                    require_once "../../includes/Database.php";
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

            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control">
            </div>

            <div class="form-group">
                <label for="turno">Turno:</label>
                <select required name="turno" id="turno" class="form-select">
                    <option selected disabled>Seleccione un turno</option>
                    <option value="1">8am - 12pm</option>
                    <option value="2">1pm - 5pm</option>
                </select>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary">Solicitar Consulta Médica</button>
            </div>
        </form>
    </div>
</section>

<?php require("../../template/footer.php") ?>