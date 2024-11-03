<?php require("../template/header.php") ?>

<a href="../controllers/cerrar_sesion.php" class="btn btn-secondary my-3 mx-4">Cerrar Sesión</a>

<!-- Contenido principal -->
<section class="container mt-5">
    <h1 class="text-center">Paciente</h1>
    <div class="row my-4 d-flex justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <a href="./solicitar_cita.php" class="btn btn-warning mb-3">Solicitar cita médica</a>
                    <a href="#" class="btn btn-warning mb-3">Registro de pago de consultas</a>
                    <a href="./realizar_pago.php" class="btn btn-warning mb-3">Realizar Pagos</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require("../template/footer.php") ?>