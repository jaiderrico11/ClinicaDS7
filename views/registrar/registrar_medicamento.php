<?php
include "../../includes/Database.php";
include "../../includes/Padecimientos.php";

$database = new Database();
$db = $database->getConnection();

$padecimientos = new Padecimientos($db);
$padecimientos_list = $padecimientos->obtener_padecimientos();
?>

<?php require('../../template/header.php'); ?>
<body>
    <div class="container">
        <h2>Insertar Medicamento</h2>
        <form action="../../controllers/procesar_medicamentos.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Medicamento:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="unidad">Unidad:</label>
                <input type="text" id="unidad" name="unidad" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input type="text" id="tipo" name="tipo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tratamiento">Tratamiento:</label>
                <input type="text" id="tratamiento" name="tratamiento" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="id_padecimiento">Padecimiento:</label>
                <select id="id_padecimiento" name="id_padecimiento" class="form-select" required>
                    <option value="" selected disabled>Seleccione un padecimiento</option>
                    <?php foreach ($padecimientos_list as $padecimiento): ?>
                        <option value="<?php echo $padecimiento['id_padecimiento']; ?>"><?php echo htmlspecialchars($padecimiento['padecimiento']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Insertar</button>
        </form>

        <h2 class="mt-5">Lista de Medicamentos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Tipo</th>
                    <th>Tratamiento</th>
                    <th>ID Padecimiento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM medicamentos";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($medicamentos as $medicamento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($medicamento['medicamento_id']); ?></td>
                        <td><?php echo htmlspecialchars($medicamento['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($medicamento['cantidad']); ?></td>
                        <td><?php echo htmlspecialchars($medicamento['unidad']); ?></td>
                        <td><?php echo htmlspecialchars($medicamento['tipo']); ?></td>
                        <td><?php echo htmlspecialchars($medicamento['tratamiento']); ?></td>
                        <td><?php echo htmlspecialchars($medicamento['id_padecimiento']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
<?php require('../../template/footer.php'); ?>