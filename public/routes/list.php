<?php
session_start();
include '../../includes/auth_check.php';
include '../../includes/functions.php';

$rutas = readJson('rutas.json');

include '../../includes/header.php';
?>

<h2>Lista de Rutas</h2>
<a href="create.php" class="button">Crear Nueva Ruta</a>

<?php if(empty($rutas)): ?>
    <li>No hay rutas disponibles.</li>

<?php else: ?>
    <?php foreach($rutas as $ruta): ?>
        <li>

            <h3><?= sanitize($ruta['datos']['nombre']) ?></h3>

            <p><strong>Dificultad:</strong> <?= sanitize($ruta['datos']['dificultad']) ?></p>
            <p><strong>Distancia:</strong> <?= sanitize($ruta['datos']['distancia']) ?> km</p>
            <p><strong>Desnivel:</strong> <?= sanitize($ruta['datos']['desnivel']) ?> m</p>
            <p><strong>Duración:</strong> <?= sanitize($ruta['datos']['duracion']) ?> h</p>
            <p><strong>Provincia:</strong> <?= sanitize($ruta['datos']['provincia']) ?></p>


            <p><strong>Fotos:</strong>
                <?= implode(", ", array_map('sanitize', $ruta['datos']['epoca'])) ?>
            </p>

            <?php if(!empty($ruta['fotos'])): ?>
                <div style="margin-top:10px;">
                    <?php foreach($ruta['fotos'] as $foto): ?>
                        <img src="<?= $base_url ?>/uploads/photos/<?= sanitize($foto) ?>" 
                             width="120"
                             style="margin-right:10px; border-radius:5px;"
                             alt="<?= sanitize($ruta['datos']['nombre']) ?>">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </li>
    <?php endforeach; ?>
<?php endif; ?>

<?php include '../../includes/footer.php'; ?>
