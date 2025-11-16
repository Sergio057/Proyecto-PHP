<?php
session_start();
include '../includes/functions.php';

$errors = [];
$formData = ['username'=>'','email'=>'','password'=>'','confirm_password'=>'','nivel_experiencia'=>'','especialidad'=>'','provincia'=>''];
$usuariosFile = 'usuarios.json';
$usuarios = readJson($usuariosFile);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = array_map('trim', $_POST);

    if (empty($formData['username'])) $errors['username'] = "El nombre es obligatorio.";
    if (empty($formData['email']) || !validateEmail($formData['email'])) $errors['email'] = "Email inválido.";
    if (empty($formData['password']) || strlen($formData['password']) < 6) $errors['password'] = "Contraseña mínimo 6 caracteres.";
    if ($formData['password'] !== $formData['confirm_password']) $errors['confirm_password'] = "Las contraseñas no coinciden.";

    foreach ($usuarios as $user) {
        if ($user['email'] === $formData['email']) $errors['email'] = "Email ya registrado.";
    }

    if (empty($errors)) {
        $usuarios[] = [
            'username'=>$formData['username'],
            'email'=>$formData['email'],
            'password'=>password_hash($formData['password'], PASSWORD_DEFAULT),
            'nivel_experiencia'=>$formData['nivel_experiencia'],
            'especialidad'=>$formData['especialidad'],
            'provincia'=>$formData['provincia']
        ];
        writeJson($usuariosFile,$usuarios);
        header("Location: login.php");
        exit;
    }
}

include '../includes/header.php';
?>

<h2>Registro de Usuario</h2>
<form method="post">
    <label>Nombre: <input type="text" name="username" value="<?= sanitize($formData['username']) ?>"></label>
    <span class="error"><?= $errors['username'] ?? '' ?></span><br>

    <label>Email: <input type="email" name="email" value="<?= sanitize($formData['email']) ?>"></label>
    <span class="error"><?= $errors['email'] ?? '' ?></span><br>

    <label>Contraseña: <input type="password" name="password"></label>
    <span class="error"><?= $errors['password'] ?? '' ?></span><br>

    <label>Confirmar Contraseña: <input type="password" name="confirm_password"></label>
    <span class="error"><?= $errors['confirm_password'] ?? '' ?></span><br>

    <label>Nivel de Experiencia: <input type="text" name="nivel_experiencia" value="<?= sanitize($formData['nivel_experiencia']) ?>"></label><br>
    <label>Especialidad: <input type="text" name="especialidad" value="<?= sanitize($formData['especialidad']) ?>"></label><br>
    <label>Provincia: <input type="text" name="provincia" value="<?= sanitize($formData['provincia']) ?>"></label><br>

    <button type="submit">Registrar</button>
</form>

<?php include '../includes/footer.php'; ?>
