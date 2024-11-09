<?php require("../../template/header.php") ?>
<div class="p-4" id="content">
    <a href="../../controllers/cerrar_sesion.php" class="btn btn-secondary my-3 mx-4">Cerrar Sesión</a>
    <!-- Contenido principal -->
    <section class="container mt-5">
        <h1 class="text-center">Gestión de Medicos</h1>
        <div class="row my-4 d-flex justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <p class="card-text">Ajusta las configuraciones globales.</p>
                        <a href="../listas/lista_pacientes.php" class="btn btn-primary mb-3">Lista de pacientes</a>
                        <a href="../registrar/horario.php" class="btn btn-primary mb-3">Mi horario</a>
                        <a href="../consultar/consultar_citas_del_dia.php" class="btn btn-primary mb-3">Consultar citas del día</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require("../../template/footer.php") ?>