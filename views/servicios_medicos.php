<?php
require("../template/header.php");
include("../includes/Database.php");
include("../includes/Servicios_Medicos.php");

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

$servicios_medicos = new Servicios_Medicos($db);

$result = $servicios_medicos->consultarServicios();

?>
<a href="../index.php" class="btn btn-secondary my-3 mx-4">Regresar</a>

<section class="container">
    <div class="text-center">
        <a href="#" class="btn btn-primary">Agregar +</a>
    </div>

    <?php if (isset($result) && !empty($result)) : ?>
        <div class="row my-4">
            <?php foreach ($result as $row) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['nombre_servicio']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="my-4 text-center">No hay servicios registrados.</p>
    <?php endif; ?>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php require("../template/footer.php") ?>