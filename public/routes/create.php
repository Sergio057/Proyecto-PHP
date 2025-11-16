<?php
session_start();
include '../../includes/auth_check.php';
include '../../includes/functions.php';

// Inicializar errores y datos del formulario
$errors = [];
$formData = [
    'nombre'=>'',
    'dificultad'=>'',
    'distancia'=>'',
    'desnivel'=>'',
    'duracion'=>'',
    'provincia'=>'',
    'epoca'=>[],
    'descripcion'=>'',
    'nivel_tecnico'=>'',
    'nivel_fisico'=>''
];

$rutas = readJson('rutas.json');

if ($_SERVER['REQUEST_METHOD']==='POST') {

    // Aplicar trim solo a strings, dejar arrays intactos
    $formData = [];
    foreach($_POST as $key => $value){
        if(is_array($value)){
            $formData[$key] = $value; // dejar arrays como están
        } else {
            $formData[$key] = trim($value); // limpiar strings
        }
    }

    // Asegurarse de que epoca siempre exista
    $formData['epoca'] = $_POST['epoca'] ?? [];

    // Validaciones
    if(empty($formData['nombre'])) $errors['nombre']="Nombre obligatorio.";
    if(empty($formData['dificultad'])) $errors['dificultad']="Selecciona dificultad.";
    if(!is_numeric($formData['distancia'])) $errors['distancia']="Distancia debe ser numérica.";
    if(!is_numeric($formData['desnivel'])) $errors['desnivel']="Desnivel debe ser numérico.";
    if(!is_numeric($formData['duracion'])) $errors['duracion']="Duración debe ser numérica.";

    // Subida de fotos
    $uploadedFiles = [];
    if(!empty($_FILES['fotos']['name'][0])) {
        $uploadDir = __DIR__ . '/../../uploads/photos/';
        foreach($_FILES['fotos']['tmp_name'] as $key=>$tmp_name){
            $name = basename($_FILES['fotos']['name'][$key]);
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if(!in_array($ext,['jpg','jpeg','png'])){ $errors['fotos']="Solo imágenes jpg, jpeg, png."; break; }
            if($_FILES['fotos']['size'][$key]>2*1024*1024){ $errors['fotos']="Cada imagen máximo 2MB."; break; }

            $newName = uniqueFileName($name);
            move_uploaded_file($tmp_name, $uploadDir.$newName);
            $uploadedFiles[]=$newName;
        }
    }

    // Guardar si no hay errores
    if(empty($errors)){
        $rutas[] = ['datos'=>$formData,'fotos'=>$uploadedFiles];
        writeJson('rutas.json',$rutas);
        header("Location: list.php");
        exit;
    }
}

include '../../includes/header.php';
?>

<h2>Crear Nueva Ruta</h2>
<form method="post" enctype="multipart/form-data">
    <label>Nombre: <input type="text" name="nombre" value="<?= sanitize($formData['nombre']) ?>"></label>
    <span class="error"><?= $errors['nombre'] ?? '' ?></span><br>

    <label>Dificultad:
        <select name="dificultad">
            <option value="">--Seleccionar--</option>
            <option value="facil" <?= $formData['dificultad']=='facil'?'selected':'' ?>>Fácil</option>
            <option value="moderada" <?= $formData['dificultad']=='moderada'?'selected':'' ?>>Moderada</option>
            <option value="dificil" <?= $formData['dificultad']=='dificil'?'selected':'' ?>>Difícil</option>
            <option value="muy dificil" <?= $formData['dificultad']=='muy dificil'?'selected':'' ?>>Muy Difícil</option>
        </select>
    </label>
    <span class="error"><?= $errors['dificultad'] ?? '' ?></span><br>

    <label>Distancia (km): <input type="text" name="distancia" value="<?= sanitize($formData['distancia']) ?>"></label>
    <span class="error"><?= $errors['distancia'] ?? '' ?></span><br>

    <label>Desnivel positivo (m): <input type="text" name="desnivel" value="<?= sanitize($formData['desnivel']) ?>"></label>
    <span class="error"><?= $errors['desnivel'] ?? '' ?></span><br>

    <label>Duración (h): <input type="text" name="duracion" value="<?= sanitize($formData['duracion']) ?>"></label>
    <span class="error"><?= $errors['duracion'] ?? '' ?></span><br>

    <label>Provincia: <input type="text" name="provincia" value="<?= sanitize($formData['provincia']) ?>"></label><br>

    <label>Época recomendada:</label><br>
    <input type="checkbox" name="epoca[]" value="primavera" <?= in_array('primavera',$formData['epoca'])?'checked':'' ?>> Primavera
    <input type="checkbox" name="epoca[]" value="verano" <?= in_array('verano',$formData['epoca'])?'checked':'' ?>> Verano
    <input type="checkbox" name="epoca[]" value="otoño" <?= in_array('otoño',$formData['epoca'])?'checked':'' ?>> Otoño
    <input type="checkbox" name="epoca[]" value="invierno" <?= in_array('invierno',$formData['epoca'])?'checked':'' ?>> Invierno
    <span class="error"><?= $errors['epoca'] ?? '' ?></span><br>

    <label>Descripción:</label>
    <textarea name="descripcion"><?= sanitize($formData['descripcion']) ?></textarea><br>

    <label>Nivel técnico (1-5): <input type="number" name="nivel_tecnico" min="1" max="5" value="<?= sanitize($formData['nivel_tecnico']) ?>"></label><br>
    <label>Nivel físico (1-5): <input type="number" name="nivel_fisico" min="1" max="5" value="<?= sanitize($formData['nivel_fisico']) ?>"></label><br>

    <label>Fotos: <input type="file" name="fotos[]" multiple></label>
    <span class="error"><?= $errors['fotos'] ?? '' ?></span><br>

    <button type="submit">Crear Ruta</button>
</form>

<?php include '../../includes/footer.php'; ?>
