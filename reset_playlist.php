<?php
require_once "utils.php";

session_start();
$config = include('config.php');
if($config['debug']){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if(!isset($_COOKIE['login'])){
    header("Location: /");
    exit();
}

if (isset($_GET["room"]) && isset($_GET["profile"])) {
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $room = validateInput($conn,$_GET["room"]); 

    $conn->query("DELETE FROM songs WHERE roomname = '$room'");
    $conn->close();

    header("Location: room.php?room=" . noAND($_GET['room']) . "&profile=" . noAND($_GET["profile"]));
} else {
    require "html/error.html";
}
?>