<?php
include "../includes/Database.php";
include "../includes/Medicamentos.php";
include "../includes/Padecimientos.php";

$database = new Database();
$db = $database->getConnection();

$medicamentos = new Medicamentos($db);
$padecimientos = new Padecimientos($db);

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicamentos->nombre = $_POST["nombre"];
    $medicamentos->cantidad = $_POST["cantidad"];
    $medicamentos->unidad = $_POST["unidad"];
    $medicamentos->tipo = $_POST["tipo"];
    $medicamentos->tratamiento = $_POST["tratamiento"];
    $medicamentos->id_padecimiento = $_POST["id_padecimiento"];

    if ($medicamentos->insertar_medicamento()) {
        $success_message = 'Medicamento insertado exitosamente.';
    } else {
        $error_message = 'Error al insertar el medicamento.';
    }
}

$query_padecimientos = "SELECT id_padecimiento, padecimiento FROM padecimiento";
$stmt_padecimientos = $db->prepare($query_padecimientos);
$stmt_padecimientos->execute();
$padecimientos = $stmt_padecimientos->fetchAll(PDO::FETCH_ASSOC);

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
        <a href="../views/registrar/registrar_medicamento.php" class="btn btn-primary">Volver a registrar medicamento</a>
    </div>
</section>
<?php require("../template/footer.php"); ?>