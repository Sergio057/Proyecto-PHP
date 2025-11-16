

<?php
// CÁLCULO DE LA RUTA BASE DEL PROYECTO
$current_dir = str_replace('\\', '/', __DIR__);
$project_root = dirname($current_dir);
$document_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$base_url = str_replace($document_root, '', $project_root);

if ($base_url === '') {
    $base_url = '/';
}

// $base_url AHORA ES (ej: /mountain-connect)
// $base AHORA ES (ej: /mountain-connect/public)
$base = $base_url . '/public';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MountainConnect</title>
    
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    
</head>
<body>
<header>
    <h1>MountainConnect</h1>
    <nav>
        <?php if(isset($_SESSION['logged_user'])): ?>
            
            <a href="<?php echo $base; ?>/index.php">Inicio</a>
            <a href="<?php echo $base; ?>/profile.php">Perfil</a>
            <a href="<?php echo $base; ?>/routes/list.php">Rutas</a>
            <a href="<?php echo $base; ?>/logout.php">Salir</a>
            
        <?php else: ?>
        
            <a href="<?php echo $base; ?>/index.php">Inicio</a>
            <a href="<?php echo $base; ?>/login.php">Login</a>
            <a href="<?php echo $base; ?>/register.php">Registrarse</a>
            
        <?php endif; ?>
    </nav>
</header>
<main>