<?php 
session_start(); 
include '../includes/functions.php';
include '../includes/header.php'; 

$rutas = readJson('rutas.json');
$destacadas = array_slice($rutas, 0, 3);
?>

<section class="hero">
    <h1>¡Bienvenido a MountainConnect!</h1>
    <p>Descubre rutas, comparte tus aventuras y conecta con montañeros.</p>
    
            <?php if(!isset($_SESSION['logged_user'])): ?>
        <a href="register.php" class="button hero-btn" style="display: block !important; margin: 0 auto 15px auto;">Comienza Ahora</a>
    <?php else: ?>
        <a href="profile.php" class="button hero-btn" style="display: block !important; margin: 0 auto 15px auto;">Mi Perfil</a>
    <?php endif; ?>

        <img src="https://cdn.mammothbikes.com/blogs/large/230216_1.jpg" alt="Foto de bicicletas en un sendero de montaña">
</section>

<?php include '../includes/footer.php'; ?>