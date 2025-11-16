<?php
// Sanear texto
function sanitize($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

// Validar email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Generar nombre único para archivos
function uniqueFileName($filename) {
    return uniqid().'_'.basename($filename);
}

// Formatear fecha
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

// Verificar sesión activa
function checkSession() {
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    return isset($_SESSION['logged_user']);
}

// Obtener ruta absoluta de un archivo JSON
function getJsonPath($file) {
    // Carpeta raíz del proyecto
    $projectRoot = realpath(__DIR__ . '/../'); // includes/..
    $dataDir = $projectRoot . DIRECTORY_SEPARATOR . 'data';

    // Crear carpeta data si no existe
    if(!is_dir($dataDir)){
        mkdir($dataDir, 0777, true);
    }

    // El archivo final siempre está dentro de data/
    $filePath = $dataDir . DIRECTORY_SEPARATOR . $file;

    // Crear archivo vacío si no existe
    if(!file_exists($filePath)){
        file_put_contents($filePath, '[]');
    }

    return $filePath;
}

// Leer JSON
function readJson($file) {
    $filePath = getJsonPath($file);
    return json_decode(file_get_contents($filePath), true) ?? [];
}

// Guardar JSON
function writeJson($file, $data) {
    $filePath = getJsonPath($file);
    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
}
    
define('PROJECT_ROOT', dirname(__DIR__));