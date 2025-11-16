<?php
session_start();
include '../../includes/auth_check.php';
include '../../includes/functions.php';

$rutas = readJson('rutas.json');

include '../../includes/header.php';
?>

<div class="container mt-4">

    <h2 class="mb-4">Lista de Rutas</h2>

   <a href="create.php" class="button">Crear Nueva Ruta</a>

    <div class="row">
    <?php if(empty($rutas)): ?>

        <div class="alert alert-info">No hay rutas disponibles.</div>

    <?php else: ?>

        <?php foreach($rutas as $ruta): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">

                    <?php if(!empty($ruta['fotos'])): ?>
                        <img 
                            src="<?= $base_url ?>/uploads/photos/<?= sanitize($ruta['fotos'][0]) ?>" 
                            class="card-img-top"
                            alt="<?= sanitize($ruta['datos']['nombre']) ?>"
                            style="object-fit:cover; height:200px;">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                             style="height:200px;">
                            Sin imagen
                        </div>
                    <?php endif; ?>

                    <div class="card-body">

                        <h5 class="card-title">
                            <?= sanitize($ruta['datos']['nombre']) ?>
                        </h5>

                        <p class="card-text mb-1">
                            <strong>Dificultad:</strong> 
                            <?= sanitize($ruta['datos']['dificultad']) ?>
                        </p>

                        <p class="card-text mb-1">
                            <strong>Distancia:</strong> 
                            <?= sanitize($ruta['datos']['distancia']) ?> km
                        </p>

                        <p class="card-text mb-1">
                            <strong>Desnivel:</strong> 
                            <?= sanitize($ruta['datos']['desnivel']) ?> m
                        </p>

                        <p class="card-text mb-1">
                            <strong>Duración:</strong> 
                            <?= sanitize($ruta['datos']['duracion']) ?> h
                        </p>

                        <p class="card-text mb-1">
                            <strong>Provincia:</strong> 
                            <?= sanitize($ruta['datos']['provincia']) ?>
                        </p>

                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
