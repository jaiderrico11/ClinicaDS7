<?php require("../template/header.php"); ?>


<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <h1 class="text-center mb-5">Registrar Paciente</h1>
            <form action="../controllers/procesar_pacientes.php" method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" required id="nombre" name="nombre" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="cedula" class="form-label">Cédula</label>
                    <input type="text" required id="cedula" name="cedula" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" required id="fecha_nacimiento" name="fecha_nacimiento" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="genero" class="form-label">Género</label>
                    <select name="genero" required id="genero" class="form-select">
                        <option value="" selected disabled>Seleccione un genero</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="text" required id="telefono" name="telefono" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" required id="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Direccion</label>
                    <input type="direccion" required id="direccion" name="direccion" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" required id="contrasena" name="contrasena" class="form-control">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Registrar Paciente</button>
                </div>

                <div class="text-center mt-2">
                    <a href="/views/inicio_recepcionista.php" class="btn btn-secondary my-3 mx-4">Regresar</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require("../template/footer.php"); ?>