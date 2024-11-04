<?php require("../../template/header.php") ?>


<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <h1 class="text-center mb-5">Añadir Servicios Médicos</h1>
            <form action="../../controllers/registrar_servicios.php" method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" required id="nombre" name="nombre" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" required id="descripcion" name="descripcion" class="form-control">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>

                <div class="text-center mt-2">
                    <a href="../listas/servicios_medicos.php" class="btn btn-secondary my-3 mx-4">Regresar</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require("../../template/footer.php") ?>