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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["room"]) && isset($_GET["profile"])) {
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $room = validateInput($conn,$_GET["room"]);
    $song = validateInput($conn,$_POST['song']);
    $type = $conn->real_escape_string($_POST["type"]);
    $method = $conn->real_escape_string($_POST["method"]);
    if ($method === 'url' && !preg_match('/^https?:\/\//i', $song)) {
        $song = 'https://' . $song;
    }

    if(!$type){
        $conn->query(
            "INSERT INTO songs (roomname, name, method)
            VALUES ('$room', '$song', '$method')"
        );
    }else{
        $conn->query(
            "INSERT INTO songs (roomname, name, method, type)
            VALUES ('$room', '$song', '$method', '$type')"
        );
    }

    $conn->close();

    header("Location: room.php?room=" . noAND($_GET['room']) . "&profile=" . noAND($_GET['profile']));
} else {
    require "html/error.html";
}
?>