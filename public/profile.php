<?php
// Iniciar sesión si no está activa
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Incluimos auth_check y funciones
include '../includes/auth_check.php';
include '../includes/functions.php';

$user = $_SESSION['logged_user'];
include '../includes/header.php';
?>

<div class="profile">
    <h2>Perfil de Usuario</h2>
    <p>Bienvenido, <?= sanitize($user['username']) ?></p>
    <p>Email: <?= sanitize($user['email']) ?></p>
    <p>Nivel: <?= sanitize($user['nivel_experiencia']) ?></p>
    <p>Especialidad: <?= sanitize($user['especialidad']) ?></p>
    <p>Provincia: <?= sanitize($user['provincia']) ?></p>
    <a href="logout.php" class="button">Cerrar sesión</a>
</div>

<?php include '../includes/footer.php'; ?>
