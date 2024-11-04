<?php require('../../controllers/procesar_medicamentos.php'); ?>
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
            <button type="submit" class="btn btn-primary">Insertar</button>
        </form>

        <h2>Lista de Medicamentos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicamentos as $medicamento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($medicamento['medicamento_id']); ?></td>
                        <td><?php echo htmlspecialchars($medicamento['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($medicamento['cantidad']); ?></td>
                        <td><?php echo htmlspecialchars($medicamento['unidad']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php require('../../template/footer.php'); ?>