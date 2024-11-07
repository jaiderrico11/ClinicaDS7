<?php
require("../../template/header.php"); ?>

<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4 text-center">
            <h1 class="mb-5">Cancelar Cita</h1>
            <form action="../../controllers/procesar_cancelar_cita.php" method="post">
                <input type="hidden" name="cita_id" value="<?php echo htmlspecialchars($_GET["cita_id"]) ?>">
                <p>¿Estas seguro de cancelar la cita?</p>
                <div>
                    <button type="submit" class="btn btn-danger">Cancelar</button>
                </div>
                <div class="my-3">
                    <a href="../listas/lista_citas.php" class="btn btn-secondary">Regresar a lista de citas</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require("../../template/footer.php"); ?>