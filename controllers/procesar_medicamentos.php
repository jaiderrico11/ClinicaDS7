<?php
require_once '../includes/Database.php';
$database = new Database();
$db = $database->getConnection();
$success_message = '';
$error_message = '';
$insertado = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $unidad = $_POST['unidad'];
    $query = "INSERT INTO medicamentos (nombre, cantidad, unidad) VALUES (:nombre, :cantidad, :unidad)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':unidad', $unidad);
    if ($stmt->execute()) {
        $success_message = 'Medicamento insertado exitosamente.';
        $insertado = true; 
    } else {
        $error_message = 'Error al insertar el medicamento.';
    }
}

$query = "SELECT * FROM medicamentos";
$stmt = $db->prepare($query);
$stmt->execute();
$medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <?php if ($insertado): ?>
            <a href="../views/consultar_medicamentos.php" class="btn btn-primary">Volver a Medicamentos</a>
        <?php endif; ?>
    </div>
</section>
<?php require("../template/footer.php"); ?>