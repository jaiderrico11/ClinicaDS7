<?php
include "../includes/Database.php";
include "../includes/Insumos.php";

$database = new Database();
$db = $database->getConnection();
$insumos = new Insumos($db);

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insumos->nombre = $_POST['nombre'];
    $insumos->cantidad = $_POST['cantidad'];
    $insumos->unidad = $_POST['unidad'];

    if ($insumos->insertar_insumo()) {
        $success_message = 'Insumo insertado exitosamente.';
    } else {
        $error_message = 'Error al insertar el insumo.';
    }
}

$insumos_list = $insumos->obtener_insumos();
$insumos = $insumos_list->fetchAll(PDO::FETCH_ASSOC);

require("../template/header.php");
?>
<section class="container mt-5">
    <div class="text-center">
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <a href="../views/consultar_insumos.php" class="btn btn-primary">Volver a Insumos</a>
    </div>
</section>
<?php require("../template/footer.php"); ?>