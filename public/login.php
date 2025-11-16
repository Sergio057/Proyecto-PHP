<?php
session_start();
include '../includes/functions.php';

$errors = [];
$usuariosFile = 'usuarios.json';
$usuarios = readJson($usuariosFile);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username']);
    $password = trim($_POST['password']);
    $found = false;

    foreach ($usuarios as $user) {
        if (($user['username']===$usernameOrEmail || $user['email']===$usernameOrEmail) && password_verify($password,$user['password'])) {
            $_SESSION['logged_user'] = $user;
            $found = true;
            header("Location: profile.php");
            exit;
        }
    }
    if(!$found) $errors['login'] = "Credenciales incorrectas.";
}

include '../includes/header.php';
?>

<h2>Login</h2>
<form method="post">
    <label>Usuario o Email: <input type="text" name="username"></label><br>
    <label>Contraseña: <input type="password" name="password"></label><br>
    <span class="error"><?= $errors['login'] ?? '' ?></span><br>
    <button type="submit">Entrar</button>
</form>

<?php include '../includes/footer.php'; ?>
