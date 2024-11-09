<?php require("../../template/header.php"); ?>
<section class="container">
    <a href="../inicio/medico_inicio.php" class="btn btn-secondary my-3 mx-4">Regresar</a>
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <h1 class="text-center">Mi Horario</h1>
            <form action="../../controllers/procesar_horario.php" method="post">
                <input class="d-none" type="number" id="cita_id" name="cita_id">

                <div class="mb-3">
                    <label for="dia" class="form-label">Día</label>
                    <input type="date" required id="dia" name="dia" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="turno" class="form-label">Turno</label>
                    <select name="turno" id="turno" class="form-select">
                        <option selected disabled>Seleccione un turno</option>
                        <option value="1">8am - 12pm</option>
                        <option value="2">1pm - 5pm</option>
                    </select>
                </div>

                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-primary">Crear cita</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require("../../template/footer.php") ?>