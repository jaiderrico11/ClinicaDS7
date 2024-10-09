<?php
require("../template/header.php");
include("../includes/Database.php");
include("../includes/Servicios_Medicos.php");

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

$servicios_medicos = new Servicios_Medicos($db);

$result = $servicios_medicos->consultar_servicios();

?>
<a href="../views/admin_inicio.php" class="btn btn-secondary my-3 mx-4">Regresar</a>

<section class="container">
    <div class="text-center">
        <h1 class="mb-4">Servicios Médicos</h1>
        <a href="./agregar_servicios.php" class="btn btn-primary">Agregar +</a>
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

<?php require("../template/footer.php") ?>