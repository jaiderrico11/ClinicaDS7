<?php require('../../controllers/procesar_padecimiento.php'); ?>
<?php require('../../template/header.php'); ?>
<body>
    <div class="container">
        <h2>Insertar Padecimiento</h2>
        <form action="../../controllers/procesar_padecimiento.php" method="POST">
            <div class="form-group">
                <label for="padecimiento">Padecimiento:</label>
                <input type="text" id="padecimiento" name="padecimiento" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Insertar</button>
        </form>

        <h2 class="mt-5">Lista de Padecimientos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Padecimiento</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($padecimientos as $padecimiento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($padecimiento['id_padecimiento']); ?></td>
                        <td><?php echo htmlspecialchars($padecimiento['padecimiento']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
<?php require('../../template/footer.php'); ?>