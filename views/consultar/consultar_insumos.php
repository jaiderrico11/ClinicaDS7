<?php require('../../template/header.php'); ?>

<body>
    <div class="container">
        <h2>Insertar Insumo</h2>
        <form action="../../controllers/procesar_insumos.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Insumo:</label>
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

        <h2>Lista de Insumos</h2>
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
                <?php
                include "../../includes/Database.php";
                include "../../includes/Insumos.php";

                $database = new Database();
                $db = $database->getConnection();
                $insumos = new Insumos($db);

                $insumos_list = $insumos->obtener_insumos();
                $insumos = $insumos_list->fetchAll(PDO::FETCH_ASSOC);

                foreach ($insumos as $insumo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($insumo['insumo_id']); ?></td>
                        <td><?php echo htmlspecialchars($insumo['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($insumo['cantidad']); ?></td>
                        <td><?php echo htmlspecialchars($insumo['unidad']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php require('../../template/footer.php'); ?>