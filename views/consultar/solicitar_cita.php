<?php require("../../template/header.php") ?>

<section class="container">
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <form action="../../controllers/procesar_solicitar_cita.php" method="post">
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

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary">Solicitar Consulta Médica</button>
            </div>
        </form>
    </div>
</section>

<?php require("../../template/footer.php") ?>