<?php require("../../template/header.php") ?>

<a href="../../controllers/cerrar_sesion.php" class="btn btn-secondary my-3 mx-4">Cerrar Sesión</a>

<!-- Contenido principal -->
<section class="container mt-5">
    <h1 class="text-center">Gestión de Recepción</h1>
    <div class="row my-4 d-flex justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <p class="card-text">Ajusta las configuraciones globales.</p>
                    <a href="../registrar/registrar_paciente.php" class="btn btn-warning mb-3">Registro de pacientes</a>
                    <a href="#" class="btn btn-warning mb-3">Registro de pago de consultas</a>
                    <a href="../consultar/consultar_disponibilidad_medico.php" class="btn btn-warning mb-3">Consultar Disponibilidad de Medicos</a>
                    <a href="../listas/gestion_citas.php" class="btn btn-warning mb-3">Creación de Citas</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require("../../template/footer.php") ?>