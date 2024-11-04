<?php
include "../../controllers/consultar_usuario.php";
require("../../template/header.php"); ?>

<section class="container">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4 text-center">
            <h1 class="mb-5">Eliminar Usuario</h1>
            <p><strong>Nombre: </strong><?php echo htmlspecialchars($usuario["nombre"]) ?></p>
            <p><strong>Email: </strong><?php echo htmlspecialchars($usuario["email"]) ?></p>
            <p><strong>Rol: </strong><?php echo htmlspecialchars($usuario["rol"]) ?></p>
            <form action="../../controllers/procesar_eliminar_usuario.php" method="post">
                <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($usuario["usuario_id"]) ?>">
                <div class="my-3">
                    <a href="../listas/lista_usuarios.php" class="btn btn-secondary">Regresar a lista de usuarios</a>
                </div>
                <div>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require("../../template/footer.php"); ?>