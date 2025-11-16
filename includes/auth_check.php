<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['logged_user'])) {
    $root = str_replace(basename($_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);
    header("Location: ".$root."public/login.php");
    exit;
}
