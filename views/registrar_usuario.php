<?php require("../template/header.php"); ?>

<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <h1 class="text-center mb-5">Registrar Usuario</h1>
            <form action="../controllers/procesar_usuarios.php" method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" required id="nombre" name="nombre" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" required id="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" required id="contrasena" name="contrasena" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select name="rol" required id="rol" class="form-select">
                        <option value="" selected disabled>Seleccione un rol</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Médico">Médico</option>
                        <option value="Enfermería">Enfermería</option>
                        <option value="Apoyo">Apoyo</option>
                        <option value="Farmacéuticos">Farmacéuticos</option>
                        <option value="Limpieza y Mantenimiento">Limpieza y Mantenimiento</option>
                        <option value="Emergencias">Emergencias</option>
                        <option value="Recursos Humanos">Recursos Humanos</option>
                        <option value="Recepcionista">Recepcionista</option>
                    </select>
                </div>

                <div class="text-center mt-4">
                    <a href="../views/admin_inicio.php" class="btn btn-secondary my-3 mx-4">Regresar</a>
                </div>

                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-primary">Registrar usuario</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require("../template/footer.php"); ?>