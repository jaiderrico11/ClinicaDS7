<?php require("./template/header.php") ?>

<!-- Contenido principal -->
<section class="container mt-5">
    <h1 class="text-center">Bienvenido a la Clínica</h1>
    <div class="row my-4">

        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gestión Administrativa</h5>
                    <p class="card-text">Añade, elimina o modifica usuarios.</p>
                    <a href="#" class="btn btn-primary mb-3">Registrar Usuario</a>
                    <a href="#" class="btn btn-primary mb-3">Ver todos los usuarios</a>
                    <a href="./views/servicios_medicos.php" class="btn btn-primary mb-3">Definir y Consultar Servicios Médicos</a>
                    <a href="#" class="btn btn-primary mb-3">Control de Insumos e Inventario</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gestión de Recursos Humanos</h5>
                    <p class="card-text">Consulta y genera reportes del sistema.</p>
                    <a href="#" class="btn btn-success mb-3">Registro/Verificación de perfil médico</a>
                    <a href="#" class="btn btn-success mb-3">Gestión de turnos y asignación de personal</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gestión de Recepción</h5>
                    <p class="card-text">Ajusta las configuraciones globales.</p>
                    <a href="#" class="btn btn-warning mb-3">Registro de pacientes</a>
                    <a href="#" class="btn btn-warning mb-3">Registro de pago de consultas</a>
                    <a href="#" class="btn btn-warning mb-3">Creación/Modificación/Cancelación de Citas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gestión de Médicos</h5>
                    <p class="card-text">Ajusta las configuraciones globales.</p>
                    <a href="#" class="btn btn-primary mb-3">Lista de pacientes</a>
                    <a href="#" class="btn btn-primary mb-3">Consultar resultados de análisis médicos</a>
                    <a href="#" class="btn btn-primary mb-3">Consultar citas del día</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Farmacia</h5>
                    <p class="card-text">Ajusta las configuraciones globales.</p>
                    <a href="#" class="btn btn-success mb-3">Consultar disponibilidad de medicamento</a>
                    <a href="#" class="btn btn-success mb-3">Suministrar medicamentos</a>
                    <a href="#" class="btn btn-success mb-3">Solicitar reabastecimiento</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gestión de Pacientes</h5>
                    <p class="card-text">Ajusta las configuraciones globales.</p>
                    <a href="#" class="btn btn-warning mb-3">Solicitar consulta médica</a>
                    <a href="#" class="btn btn-warning mb-3">Acceder a resultados médicos</a>
                    <a href="#" class="btn btn-warning mb-3">Calendario de citas</a>
                    <a href="#" class="btn btn-warning mb-3">Actualizar información personal</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php require("./template/footer.php") ?>