<?php
require("../../includes/Database.php");
require("../../includes/Usuarios.php");
require("../../includes/Medicos.php");

$database = new Database();
$db = $database->getConnection();

$usuarios = new Usuarios($db);
$medicos = new Medicos($db);

// Verificamos si se ha recibido el ID del médico a actualizar
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Obtenemos los datos actuales del médico
    $medico = $medicos->obtener_medico_por_id($usuario_id);

    // Verificamos si se ha enviado el formulario para actualizar
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $especialidad = $_POST['especialidad'];
        $no_licencia_medica = $_POST['no_licencia_medica'];
        $anio_experiencia = $_POST['anio_experiencia'];
        $institucion = $_POST['institucion'];

        // Actualizamos los datos del médico
        $medicos->actualizar_medico($usuario_id, $especialidad, $no_licencia_medica, $anio_experiencia, $institucion);
        header("Location: ../listas/lista_medicos.php");
        exit();
    }
} else {
    // Si no se recibe el ID, redirigimos a la lista de médicos
    header("Location: ../listas/lista_medicos.php");
    exit();
}
?>

<?php require("../../template/header.php"); ?>

<section class="container">
    <h2>Actualizar Médico</h2>
    <?php if (!empty($medico)) : ?>
        <form method="post">
            <div class="mb-3">
                <label for="especialidad" class="form-label">Especialidad</label>
                <input type="text" id="especialidad" name="especialidad" class="form-control" readonly value="<?php echo htmlspecialchars($medico['nombre_servicio']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="no_licencia_medica" class="form-label">Número de Licencia Médica</label>
                <input type="text" id="no_licencia_medica" name="no_licencia_medica" class="form-control" value="<?php echo htmlspecialchars($medico['no_licencia_medica']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="anio_experiencia" class="form-label">Años de Experiencia</label>
                <input type="number" id="anio_experiencia" name="anio_experiencia" class="form-control" value="<?php echo htmlspecialchars($medico['anio_experiencia']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="institucion" class="form-label">Institución</label>
                <input type="text" id="institucion" name="institucion" class="form-control" value="<?php echo htmlspecialchars($medico['institucion']); ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Actualizar Médico</button>
            </div>
        </form>
    <?php else : ?>
        <div class="alert alert-danger">El médico no existe.</div>
    <?php endif; ?>
</section>

<?php require("../../template/footer.php"); ?>