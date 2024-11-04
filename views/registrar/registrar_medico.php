<?php require("../../template/header.php"); ?>

<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <h1 class="text-center mb-5">Registrar Médico</h1>
            <form action="../../controllers/procesar_registro_medico.php" method="post">

                <!-- Seleccionar médico desde los usuarios registrados con rol de "medico" -->
                <div class="mb-3">
                    <label for="usuario_id" class="form-label">Médico Registrado</label>
                    <select name="usuario_id" required id="usuario_id" class="form-select">
                        <option value="" selected disabled>Seleccione un médico</option>
                        <?php
                        // Obtenemos la lista de médicos desde la tabla usuarios
                        include "../../includes/Database.php";
                        include "../../includes/Usuarios.php";

                        $database = new Database();
                        $db = $database->getConnection();

                        $usuarios = new Usuarios($db);
                        $medicos = $usuarios->consultar_medicos_por_rol();

                        if ($medicos !== false && !empty($medicos)) {
                            foreach ($medicos as $medico) {
                                echo '<option value="' . $medico["usuario_id"] . '">' . htmlspecialchars($medico["nombre"]) . ' (' . htmlspecialchars($medico["email"]) . ')</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <!-- Campos adicionales para registrar al médico -->
                <div class="mb-3">
                    <label for="especialidad" class="form-label">Especialidad</label>
                    <input type="text" required id="especialidad" name="especialidad" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="no_licencia_medica" class="form-label">Número de Licencia Médica</label>
                    <input type="text" required id="no_licencia_medica" name="no_licencia_medica" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="anio_experiencia" class="form-label">Años de Experiencia</label>
                    <input type="number" required id="anio_experiencia" name="anio_experiencia" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="institucion" class="form-label">Institución</label>
                    <input type="text" required id="institucion" name="institucion" class="form-control">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Registrar médico</button>
                </div>
                <div class="text-center mt-4">
                    <a href="../listas/lista_medicos.php" class="btn btn-primary">Verificar Médicos</a>
                </div>
                <div class="text-center mt-2">
                    <a href="../../index.php" class="btn btn-secondary my-3 mx-4">Regresar</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require("../../template/footer.php"); ?>